<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    kana: '',
    email: '',
    tel: '',
    role: '',
    retirement_date: '',
    session_id: '',
    school_id: '1',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
						<TextInput
								id="school_id"
								type="hidden"
								v-model="form.school_id"
								required
								autofocus
								autocomplete="school_id"
						/>
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="kana" value="Kana" />

                <TextInput
                    id="kana"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.kana"
                    autofocus
                    autocomplete="kana"
                />

                <InputError class="mt-2" :message="form.errors.kana" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="tel" value="Tel" />

                <TextInput
                    id="tel"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.tel"
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.tel" />
            </div>

            <div class="mt-4">
                <InputLabel for="role" value="Role" />

                <div class="mt-2">
										<label class="inline-flex items-center">
												<input type="radio" id="role_admin" value="1" v-model="form.role" required />
												<span class="ml-2">編集者</span>
										</label>
										<label class="ml-4 inline-flex items-center">
												<input type="radio" id="role_admin_viewer" value="2" v-model="form.role" required />
												<span class="ml-2">閲覧者</span>
										</label>
								</div>

                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <div class="mt-4">
                <InputLabel for="retirement_date" value="Retirement date" />

                <TextInput
                    id="retirement_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.retirement_date"
                    autocomplete="retirement_date"
                />

                <InputError class="mt-2" :message="form.errors.retirement_date" />
            </div>

            <div class="mt-4">
                <InputLabel for="session_id" value="Session id" />

                <TextInput
                    id="session_id"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.session_id"
                    required
                    autocomplete="session_id"
                />

                <InputError class="mt-2" :message="form.errors.session_id" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
