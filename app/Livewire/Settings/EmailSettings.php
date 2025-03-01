<?php

namespace App\Livewire\Settings;

use App\Models\EmailSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class EmailSettings extends Component
{

    use LivewireAlert;

    public $mailFromName;
    public $mailFromEmail;
    public $enableQueue;
    public $mailDriver;
    public $verified;
    public $smtpHost;
    public $smtpPort;
    public $smtpEncryption;
    public $mailUsername;
    public $mailPassword;
    public $emailSetting;
    public $settings;

    public $formSubmitting = false;
    public $showTestEmailModal = false;
    public $testEmail = '';
    public $testEmailStatus = null;
    public $testEmailMessage = '';

    public function mount()
    {
        $this->emailSetting = EmailSetting::first();
        $this->mailFromName = $this->emailSetting->mail_from_name;
        $this->mailFromEmail = $this->emailSetting->mail_from_email;
        $this->enableQueue = $this->emailSetting->enable_queue;
        $this->mailDriver = $this->emailSetting->mail_driver;
        $this->smtpHost = $this->emailSetting->smtp_host;
        $this->smtpEncryption = $this->emailSetting->smtp_encryption;
        $this->mailUsername = $this->emailSetting->mail_username;
        $this->mailPassword = $this->emailSetting->mail_password;
        $this->smtpPort = $this->emailSetting->smtp_port;
        $this->verified = $this->emailSetting->verified;
        $this->testEmail = auth()->user()->email;
    }

    public function submitForm()
    {
        $this->validate([
            'mailFromName' => 'required',
            'mailFromEmail' => 'required',
            'smtpHost' => 'required_if:mailDriver,smtp',
            'mailUsername' => 'required_if:mailDriver,smtp',
            'mailPassword' => 'required_if:mailDriver,smtp',
            'smtpPort' => 'required_if:mailDriver,smtp',
        ]);

        $this->formSubmitting = true;
        $this->emailSetting->mail_from_name = $this->mailFromName;
        $this->emailSetting->mail_from_email = $this->mailFromEmail;
        $this->emailSetting->enable_queue = $this->enableQueue;
        $this->emailSetting->mail_driver = $this->mailDriver;
        $this->emailSetting->smtp_host = $this->smtpHost;
        $this->emailSetting->smtp_encryption = $this->smtpEncryption;
        $this->emailSetting->mail_username = $this->mailUsername;
        $this->emailSetting->mail_password = $this->mailPassword;
        $this->emailSetting->smtp_port = $this->smtpPort;
        $this->emailSetting->save();

        $this->emailSetting->fresh();

        session()->forget('smtp_setting');

        $verify = $this->verifySmtp();

        if ($verify['success']) {

            $this->alert('success', __('messages.settingsUpdated'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
        } else {
            if ($this->emailSetting->smtp_host  == 'smtp.gmail.com') {
                $message = __('messages.smtpError') . '<br><br>';
                $secureUrl = 'https://froiden.freshdesk.com/support/solutions/articles/43000672983';
                $message .= __('messages.smtpSecureEnabled');
                $message .= '<a  class="underline underline-offset-1 mb-2" target="_blank" href="' . $secureUrl . '">' . $secureUrl . '</a>';
                $message .= '<div class="mt-2">' . $verify['message'] . '</div>';
                $this->addError('smtp_error', $message);
            } else {
                $this->addError('smtp_error', '<strong>' . __('messages.smtpError') . '</strong><ul><li class="py-2">' . $verify['message'] . '</li></ul>');
            }

            $this->mount();
        }
    }

    public function verifySmtp(): array
    {

        if ($this->mailDriver !== 'smtp') {
            return [
                'success' => true,
                'message' => __('messages.smtpSuccess')
            ];
        }

        try {
            $tls = $this->smtpEncryption === 'ssl';
            $transport = new EsmtpTransport($this->smtpHost, $this->smtpPort, $tls);
            $transport->setUsername($this->mailUsername);
            $transport->setPassword($this->mailPassword);
            $transport->start();

            if ($this->emailSetting->verified == 0) {
                $this->emailSetting->verified = 1;
                $this->emailSetting->save();
            }

            return [
                'success' => true,
                'message' => __('messages.smtpSuccess')
            ];
        } catch (TransportException | \Exception $e) {
            $this->emailSetting->verified = 0;
            $this->emailSetting->save();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function sendTestEmail()
    {
        $this->validate([
            'testEmail' => 'required|email',
        ]);

        try {
            Notification::route('mail', $this->testEmail)->notify(new TestNotification());
            $this->testEmailStatus = 'success';
            $this->testEmailMessage = __('messages.testEmailSuccess');
        } catch (\Exception $e) {
            $this->testEmailStatus = 'error';
            $this->testEmailMessage = 'Failed to send test email: ' . $e->getMessage();
        }
    }

    public function closeTestEmailModal()
    {
        $this->showTestEmailModal = false;
        $this->testEmailStatus = null;
        $this->testEmailMessage = '';
    }

    public function render()
    {
        return view('livewire.settings.email-settings');
    }
}
