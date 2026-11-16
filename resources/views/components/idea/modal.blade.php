@props(['idea' => new App\Models\Idea()])
<div>
    <x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit' : 'New' }} Idea">
        <form
            x-data="{
                    status: @js(old('status',$idea->status->value)),
                    newLink: '',
                    links: @js(old('steps', $idea->links ?? [])),
                    newStep: '',
                    steps: @js(old('steps', $idea->steps->map->only(['id','description','completed'])))
                }"
            method="POST" action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
            enctype="multipart/form-data"
        >
            @csrf
            @if($idea->exists)
                @method('PATCH')
            @endif

            <div class="space-y-6" >
                <x-form.field
                    :value="$idea->title"
                    label="Title"
                    name="title"
                    placeholder="Enter an idea for your idea"
                    autofocus
                    required
                />

                <div class="space-y-2">
                    <label for="status" class="label">Status</label>

                    <div class="flex gap-x-3">
                        @foreach(App\IdeaStatus::cases() as $status)
                            <button
                                type="button"
                                data-test="button-status-{{ $status->value }}"
                                @click=" status = @js($status->value)"
                                class="btn flex-1 h-10"
                                :class="{'btn-outlined': status !== @js($status->value) }"
                            >
                                {{ $status->label() }}
                            </button>
                        @endforeach

                        <input type="hidden" name="status" :value="status" class="input">
                        <x-form.error name="status"/>
                    </div>
                </div>

                <x-form.field
                    :value="$idea->description"
                    label="Description"
                    name="description"
                    type="textarea"
                    placeholder="Describe your idea"
                />

                <div class="space-y-2">
                    <label for="image" class="label">Featured Image</label>
                    @if($idea->image_path)
                        <div class="space-y-2">
                            <img src="{{ asset('storage/'. $idea->image_path) }}" alt="{{ $idea->title }}"
                                 class="w-full h-auto object-cover rounded-lg"
                            />
                            <button type="submit" class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove Image</button>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*">
                    <x-form.error name="image"/>
                </div>

                <div>
                    <fieldset class="space-y-3">
                        <legend class="label">Actionable Steps</legend>

                        <template x-for="(step, idx) in steps" :key="idx">
                            <div class="flex gap-x-2 items-center">
                                <input
                                    :name="`steps[${idx}][description]`"
                                    x-model="step.description"
                                    class="input"
                                    readonly
                                >
                                <input
                                    type="hidden"
                                    :name="`steps[${idx}][completed]`"
                                    x-model="step.completed ? '1' : '0'"
                                >
                                <button
                                    type="button"
                                    @click="steps.splice(idx, 1)"
                                    aria-label="Remove step"
                                    class="form-muted-icon"
                                >
                                    <x-icons.close/>
                                </button>
                            </div>
                        </template>
                        <div class="flex gap-x-2 items-center">
                            <input
                                x-model="newStep"
                                id="new-step"
                                data-test="new-step"
                                placeholder="What need to be done?"
                                class="input flex-1"
                                spellcheck="false"
                            />
                            <button
                                type="button"
                                data-test="submit-new-step-button"
                                @click="steps.push({description:newStep.trim(), completed:false}); newStep = '';"
                                :disabled="newStep.trim().length === 0"
                                aria-label="Add new step"
                                class="form-muted-icon"
                            >
                                <x-icons.close class="rotate-45"/>
                            </button>
                        </div>
                    </fieldset>
                </div>

                <div>
                    <fieldset class="space-y-3">
                        <legend class="label">Links</legend>

                        <template x-for="(link, idx) in links" :key="link">
                            <div class="flex gap-x-2 items-center">
                                <input
                                    name="links[]"
                                    x-model="link"
                                    class="input"
                                    readonly
                                >
                                <button
                                    type="button"
                                    @click="links.splice(idx, 1)"
                                    aria-label="Remove link"
                                    class="form-muted-icon"
                                >
                                    <x-icons.close/>
                                </button>
                            </div>
                        </template>
                        <div class="flex gap-x-2 items-center">
                            <input
                                x-model="newLink"
                                type="url"
                                id="new-link"
                                data-test="new-link"
                                placeholder="https://exanple.com"
                                autocomplete="url"
                                class="input flex-1"
                                spellcheck="false"
                            />
                            <button
                                type="button"
                                data-test="submit-new-link-button"
                                @click="links.push(newLink.trim()); newLink = '';"
                                :disabled="newLink.trim().length === 0"
                                aria-label="Add new link"
                                class="form-muted-icon"
                            >
                                <x-icons.close class="rotate-45"/>
                            </button>
                        </div>
                    </fieldset>
                </div>

                <div class="flex justify-end gap-x-5">
                    <button type="button" @click="$dispatch('close-modal')">Cancel</button>
                    <button type="submit" class="btn">{{$idea->exists ? 'Update' : 'Create'}}</button>
                </div>
            </div>
        </form>
        @if($idea->image_path)
            <form
                action="{{ route('idea.image.destroy', $idea) }}"
                method="POST"
                id="delete-image-form"
            >
                @csrf
                @method('DELETE')
            </form>
        @endif
    </x-modal>
</div>
