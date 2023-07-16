<div class="w-full flex flex-wrap">
    <form class="w-full" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

        <div class="w-full">
        <div class="w-full flex flex-wrap">
            <label for="name">Name :</label>
            <input class="w-full rounded" id="name" type="text" wire:model.defer.lazy="state.name">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-wrap">
            <label for="name">Email :</label>
            <input class="w-full rounded" id="email" type="text" wire:model.defer.lazy="state.email">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>


        <div class="w-full flex flex-wrap">
            <label for="skills">Skills :</label>
            @livewire('component.test.selector',
            [
                'componentName' => 'skills',
                'selectorType' => 'multiple',
                'fetchFunctionName' => 'getSkills',
            ], key('skillselection0'))
            @error('skills') <span class="error">{{ $message }}</span> @enderror
        </div>
        </div>




        <div class="w-full flex flex-wrap">
            <button class="px-2 py-1 bg-blue-500 rounded" type="submit">Save Contact</button>
        </div>

    </form>
</div>
