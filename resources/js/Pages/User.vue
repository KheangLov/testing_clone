<template>
    <app-layout>
        <template #header>
            User
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-background-tertiary shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.flash.message">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.flash.message }}</p>
                            </div>
                        </div>
                    </div>
                    <jet-button type="button" @clicked="openModal">
                        Create
                    </jet-button>
                    <div class="overflow-x-auto">
                        <table class="table-fixed w-full min-w-768">
                            <thead>
                                <tr class="bg-background-secondary text-copy-secondary text-left">
                                    <th class="px-4 py-2 w-20">No.</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2 w-28">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-copy-secondary" v-for="(row, index) in data" :key="row.id">
                                    <td class="px-4 py-2">{{ index + 1 }}</td>
                                    <td class="px-4 py-2">{{ row.name }}</td>
                                    <td class="px-4 py-2">{{ row.email }}</td>
                                    <td class="px-4 py-2">
                                        <jet-button type="button" @clicked="edit(row)" classes="text-blue-500 hover:text-blue-700 focus:text-blue-700 focus:outline-none font-bold p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                        </jet-button>
                                        <jet-button type="button" @clicked="deleteRow(row)" classes="text-red-500 hover:text-red-700 focus:text-red-700 focus:outline-none font-bold p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </jet-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <jet-dialog-modal :show="show">
                        <template #title>
                            <h4 class="text-white font-bold">User {{ editMode ? 'Edit' : 'Create' }}</h4>
                        </template>
                        <template #content>
                            <custom-form @submitted="save">
                                <template #form>
                                    <div class="mb-3 text-center">
                                        <input type="file" class="hidden" ref="photo" @change="updatePhotoPreview">

                                        <!-- Current Profile Photo -->
                                        <div class="mt-2" v-show="! photoPreview">
                                            <img :src="$page.user.profile_photo_url" alt="Current Profile Photo" class="rounded-full h-20 w-20 object-cover mx-auto">
                                        </div>

                                        <!-- New Profile Photo Preview -->
                                        <div class="mt-2" v-show="photoPreview">
                                            <span class="block rounded-full w-20 h-20 mx-auto"
                                                :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                                            </span>
                                        </div>
                                        <jet-secondary-button class="mt-4" type="button" @click.native.prevent="selectNewPhoto">
                                            Select A New Photo
                                        </jet-secondary-button>

                                        <!-- <jet-secondary-button type="button" class="mt-4" @click.native.prevent="deletePhoto" v-if="$page.user.profile_photo_path">
                                            Remove Photo
                                        </jet-secondary-button> -->

                                        <jet-input-error :message="form.error('photo')" class="mt-2" />
                                    </div>
                                    <div class="mb-3">
                                        <jet-label value="Name" />
                                        <jet-input v-model="form.name" classes="w-full form-input rounded-md shadow-sm" />
                                        <jet-input-error :message="form.error('name')" class="mt-2" />
                                    </div>
                                    <div class="mb-3">
                                        <jet-label value="Email" />
                                        <jet-input type="email" v-model="form.email" classes="w-full form-input rounded-md shadow-sm" />
                                        <jet-input-error :message="form.error('email')" class="mt-2" />
                                    </div>
                                    <div class="mb-3" v-if="!editMode">
                                        <jet-label value="Password" />
                                        <jet-input type="password" v-model="form.password" classes="w-full form-input rounded-md shadow-sm" />
                                        <jet-input-error :message="form.error('password')" class="mt-2" />
                                    </div>
                                    <div class="mb-3" v-if="!editMode">
                                        <jet-label value="Confirm Password" />
                                        <jet-input type="password" v-model="form.password_confirmation" classes="w-full form-input rounded-md shadow-sm" />
                                    </div>
                                </template>
                                <template #actions>
                                    <jet-button type="button" @clicked="closeModal" classes="mr-3 text-white bg-red-500 hover:bg-red-700 focus:bg-red-700 focus:outline-none font-bold px-4 py-2 rounded-md">
                                        Cancel
                                    </jet-button>
                                    <jet-button type="submit" classes="text-white bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 focus:outline-none font-bold px-4 py-2 rounded-md">
                                        Submit
                                    </jet-button>
                                </template>
                            </custom-form>
                        </template>
                    </jet-dialog-modal>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import JetButton from '@/Jetstream/Button';
    import JetDialogModal from '@/Jetstream/DialogModal';
    import CustomForm from '@/Custom/Form';
    import JetInput from '@/Jetstream/Input';
    import JetLabel from '@/Jetstream/Label';
    import JetSecondaryButton from '@/Jetstream/SecondaryButton';
    import JetInputError from '@/Jetstream/InputError';

    export default {
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            CustomForm,
            JetInput,
            JetLabel,
            JetSecondaryButton,
            JetInputError
        },
        props: ['data', 'errors'],
        data() {
            return {
                editMode: false,
                show: false,
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    photo: null,
                }, {
                    bag: 'saveUser',
                    resetOnSuccess: false,
                }),
                photoPreview: null,
            }
        },
        methods: {
            openModal: function () {
                this.show = true;
            },
            closeModal: function () {
                this.show = false;
            },
            save: function () {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0];
                }

                // this.$inertia.visit(url, {
                //     method: 'get',
                //     data: {},
                //     replace: false,
                //     preserveState: false,
                //     preserveScroll: false,
                //     only: [],
                //     headers: {},
                //     errorBag: null,
                //     onCancelToken: cancelToken => {},
                //     onCancel: () => {},
                //     onBefore: visit => {},
                //     onStart: visit => {},
                //     onProgress: progress => {},
                //     onSuccess: page => {},
                //     onError: errors => {},
                //     onFinish: () => {},
                // })

                this.$inertia.post(route('users.store'), this.form, {
                    preserveScroll: true
                });
            },
            edit: function ({ name, email, photo }) {
                this.editMode = true;
                this.form = this.$inertia.form({
                    name,
                    email,
                    photo,
                }, {
                    bag: 'saveUpdate',
                    resetOnSuccess: false,
                });
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post(route('users.update', { id: data.id }), data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Are you sure want to remove?')) return false;

                data._method = 'DELETE';
                this.$inertia.post(route('users.soft_delete', { id: data.id }), data);
                this.reset();
                this.closeModal();
            },

            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                }).then(() => {
                    this.photoPreview = null
                });
            },
        }
    }
</script>
