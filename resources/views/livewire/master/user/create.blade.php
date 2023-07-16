
<div class="w-full px-2">

    <form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

        <div class="w-full grid grid-cols-none md:grid-cols-2 gap-y-4 gap-x-10">
            <div class="">
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="name">Name * :</label>
                    <div class="w-full">
                        <input class="col-span-3 formField" id="name" type="text" wire:model.defer.lazy="state.name">
                    </div>
                    @error('name') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="email">Email * :</label>
                    <div class="w-full">
                        <input class="col-span-3 formField" id="email" type="text" wire:model.defer.lazy="state.email">
                    </div>
                    @error('email') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="role_id">Role * :</label>
                    <div class="w-full">
                        <select class="col-span-3 formField" id="role_id" type="text" wire:model.defer.lazy="state.role_id">
                            <option value=''>Choose Role</option>
                            @foreach($roles as $role)
                                <option value="{{$role['id']}}">{{$role['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('role_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                

                
            </div>

            <div class="">
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="username">Username * :</label>
                    <div class="w-full">
                        <input class="col-span-3 formField" id="username" type="text" wire:model.defer.lazy="state.username">
                    </div>
                    @error('username') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="password">Password * :</label>
                    <div class="w-full">
                        <input class="col-span-3 formField" id="password" type="password" wire:model.defer.lazy="state.password">
                    </div>
                    @error('password') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
            </div>

        </div>


        <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5">
            <button class="btnSave" type="submit">Save</button>
        </div>
    </form>
        
</div>