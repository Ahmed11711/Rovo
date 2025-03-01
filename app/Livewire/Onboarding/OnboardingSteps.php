<?php

namespace App\Livewire\Onboarding;

use App\Models\OnboardingStep;
use Livewire\Attributes\On;
use Livewire\Component;

class OnboardingSteps extends Component
{

    public $showAddArea = false;
    public $showAddTable = false;
    public $showAddMenu = false;
    public $showAddMenuItem = false;

    #[On('areaAdded')]
    public function areaAdded()
    {
        $onboarding = OnboardingStep::first();
        $onboarding->add_area_completed = 1;
        $onboarding->save();

        $this->showAddArea = false;
    }
    
    #[On('tableAdded')]
    public function tableAdded()
    {
        $onboarding = OnboardingStep::first();
        $onboarding->add_table_completed = 1;
        $onboarding->save();

        $this->showAddTable = false;
    }

    #[On('menuAdded')]
    public function menuAdded()
    {
        $onboarding = OnboardingStep::first();
        $onboarding->add_menu_completed = 1;
        $onboarding->save();

        $this->showAddMenu = false;
    }

    #[On('menuItemAdded')]
    public function menuItemAdded()
    {
        $onboarding = OnboardingStep::first();
        $onboarding->add_menu_items_completed = 1;
        $onboarding->save();
    }

    public function showAddAreaForm()
    {
        $this->showAddMenu = false;
        $this->showAddTable = false;
        $this->showAddArea = true;
        $this->showAddMenuItem = false;
    }

    public function showAddTableForm()
    {
        $this->showAddMenu = false;
        $this->showAddTable = true;
        $this->showAddArea = false;
        $this->showAddMenuItem = false;
    }

    public function showAddMenuForm()
    {
        $this->showAddMenu = true;
        $this->showAddTable = false;
        $this->showAddArea = false;
        $this->showAddMenuItem = false;
    }

    public function showAddMenuItemForm()
    {
        $this->showAddMenu = false;
        $this->showAddTable = false;
        $this->showAddArea = false;
        $this->showAddMenuItem = true;
    }
    
    public function render()
    {
        $onboardingSteps = OnboardingStep::first();

        return view('livewire.onboarding.onboarding-steps', [
            'onboardingSteps' => $onboardingSteps
        ]);
    }

}
