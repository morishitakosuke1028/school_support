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
    gender: '',
    zip: '',
    address: '',
    tel: '',
    birthday: '',
    admission_date: '', //@TODO登録時はいらない
    movein_date: '', //@TODO登録時はいらない
    graduation_date: '', //@TODO登録時はいらない
    pin_code: '',
	  flg_del: '0',
	  session_id: '',
    email: '',
    school_id: '1',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('child.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

				<h1>生徒用アカウント作成</h1>

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
                <InputLabel for="gender" value="Gender" />

                <div class="mt-2">
										<label class="inline-flex items-center">
												<input type="radio" id="gender" value="1" v-model="form.gender" required />
												<span class="ml-2">男</span>
										</label>
										<label class="ml-4 inline-flex items-center">
												<input type="radio" id="gender" value="2" v-model="form.gender" required />
												<span class="ml-2">女</span>
										</label>
								</div>

                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

						<div class="mt-4">
                <InputLabel for="zip" value="Zip" />

                <TextInput
                    id="zip"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.zip"
                    autofocus
                    autocomplete="zip"
                />

                <InputError class="mt-2" :message="form.errors.zip" />
            </div>

						<div class="mt-4">
                <InputLabel for="address" value="Address" />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    autofocus
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

						<div class="mt-4">
                <InputLabel for="birthday" value="Birthday" />

                <TextInput
                    id="birthday"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.birthday"
                    autofocus
                    autocomplete="birthday"
                />

                <InputError class="mt-2" :message="form.errors.birthday" />
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
                <InputLabel for="pin_code" value="Pin code" />

                <TextInput
                    id="pin_code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.pin_code"
                    required
                    autocomplete="pin_code"
                />

                <InputError class="mt-2" :message="form.errors.pin_code" />
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
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
