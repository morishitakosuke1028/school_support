<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

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
		<AuthenticatedLayout>
    		<GuestLayout>
        		<Head title="職員登録" />

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
										<InputLabel for="name" value="名前" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

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
										<InputLabel for="kana" value="かな" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

										<TextInput
												id="kana"
												type="text"
												class="mt-1 block w-full"
												v-model="form.kana"
												required
												autofocus
												autocomplete="kana"
										/>

										<InputError class="mt-2" :message="form.errors.kana" />
								</div>

								<div class="mt-4">
										<InputLabel for="email" value="メールアドレス" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

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
										<InputLabel for="tel" value="電話番号" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

										<TextInput
												id="tel"
												type="text"
												class="mt-1 block w-full"
												v-model="form.tel"
												required
												autocomplete="tel"
										/>

										<InputError class="mt-2" :message="form.errors.tel" />
								</div>

								<div class="mt-4">
										<InputLabel for="role_admin" value="権限" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

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
										<InputLabel for="session_id" value="認証 ID" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

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
										<InputLabel for="password" value="パスワード" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

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
										<InputLabel for="password_confirmation" value="パスワード確認" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

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

								<div class="flex items-center justify-around mt-4">
										<Link as="button" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('dashboard')">
												トップへ
										</Link>
										<PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
												職員登録
										</PrimaryButton>
								</div>
						</form>
				</GuestLayout>
		</AuthenticatedLayout>
</template>
