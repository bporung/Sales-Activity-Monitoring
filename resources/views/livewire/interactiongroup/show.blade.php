
<div class="w-full">
    
    @push('styles')
    
    @endpush

    @include('component.alert')
    <div class="w-full flex flex-wrap">
        <div class="w-full md:w-3/5 lg:w-3/5 p-2">
            <div class=" bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Customer :</p>
                    <p class="font-normal text-lg">{{$result->customer_id }} - {{$result->customer->name }}</p>
                </div>
            </div>
            <div class=" bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Name :</p>
                    <p class="font-normal text-lg">{{$result->name}}</p>
                </div>
                <div class="mb-3">
                    <p>Description :</p>
                    <p class="font-normal text-lg">{{$result->description ? $result->description : '-'}}</p>
                </div>
                <div class="mb-3">
                    <p>Created At :</p>
                    <p class="font-normal text-lg">{{date('d/m/Y',strtotime($result->created_at))}}</p>
                </div>
                <div class="mb-3">
                    <p>Registered By :</p>
                    <p class="font-normal text-lg">{{$result->registered ? $result->registered->name : '-'}}</p>
                </div>
            </div>
        </div>
        <div class="w-full md:w-2/5 lg:w-2/5 p-2">
            <div class=" bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Status :</p>
                    @if($result->status == '1')
                        <div class="flex border-t-4 shadow rounded border-green-600 mt-2  p-3 justify-between">
                            <span class="text-green-600 text-xl"><i class="fas fa-lightbulb text-3xl"></i> ACTIVE</span>
                            @if($btnAction['update_status'])
                            <button type="button" class="text-black text-sm px-2 py-1 border border-black hover:bg-black hover:text-yellow-400 transition-all"
                            x-data="{}" x-on:click="window.livewire.emitTo('interactiongroup.method.changingstatus','show',{{$result}})"> <i class="fas fa-exclamation-triangle"></i> CLOSE NOW <i class="fas fa-lock"></i></button>
                            @endif
                        </div>
                        
                        @if($btnAction['update_status'])
                            @livewire('interactiongroup.method.changingstatus')
                        @endif
                    @else
                    <div class="flex border-t-4 shadow rounded border-gray-400 mt-2  p-3">
                        <span class="text-gray-400 text-xl"><i class="fas fa-lock text-3xl"></i>  CLOSED</span>
                    </div>
                    @endif
                </div>
            </div>
            <div class=" bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Users ( <span class="italic">That Can Access This Group</span>) :</p>
                    @if($result->users->count())
                    @foreach($result->users as $user)
                        <p class="font-normal text-md"><i class="fas fa-user-tie"></i> {{$user->name}} <span class="italic text-xs text-green-400">set at {{date("d-m-Y",strtotime($user->created_at))}}</span></p>
                    @endforeach
                    @else
                        <img src="/img/img-icon/no-user.png" class="w-24 mt-3">
                    @endif
                </div>
            </div>
        </div>
            

        <div class="w-full  p-2">
            <!-- INTERACTION -->
            <div class="mt-3 p-2 shadow bg-white">
                @livewire('interactiongroup.interaction.index',[
                    'group_id' => $result->id,    
                    'customer_id' => $result->customer_id,
                    'create_new_interaction' => $btnAction['new_interaction'] 
                ],key('interaction-1'))
            </div>
            <!-- End Of Interaction -->
        </div>
        </div>
        
        
    </div>
        
    @livewire('interactiongroup.interaction.show')

    @push('scripts')
    
    @endpush
</div>