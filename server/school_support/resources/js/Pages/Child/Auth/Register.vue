<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    admission_date: '',
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
    form.post(route('admin.child.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
		<AuthenticatedLayout>
				<GuestLayout>
						<Head title="生徒登録" />

						<h1 class="mt-2 mb-3">生徒用アカウント作成</h1>

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
										<InputLabel value="性別" />

										<div class="mt-2">
												<label for="gender_men" class="inline-flex items-center">
														<input type="radio" id="gender_men" value="1" v-model="form.gender" required />
														<span class="ml-2">男</span>
												</label>
												<label for="gender_women" class="ml-4 inline-flex items-center">
														<input type="radio" id="gender_women" value="2" v-model="form.gender" required />
														<span class="ml-2">女</span>
												</label>
										</div>

										<InputError class="mt-2" :message="form.errors.gender" />
								</div>

								<div class="mt-4">
										<InputLabel for="zip" value="郵便番号" />

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
										<InputLabel for="address" value="住所" />

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
										<InputLabel for="birthday" value="生年月日" />

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
										<InputLabel for="admission_date" value="入学日" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

										<TextInput
												id="admission_date"
												type="date"
												class="mt-1 block w-full"
												v-model="form.admission_date"
												autofocus
												required
												autocomplete="admission_date"
										/>

										<InputError class="mt-2" :message="form.errors.admission_date" />
								</div>

								<div class="mt-4">
										<InputLabel for="email" value="保護者メールアドレス" />

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
										<InputLabel for="pin_code" value="簡易認証コード" />
										<span class="font-medium text-sm text-red-700">　(必須)</span>

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
										<Link as="button" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('attendance.index')">
												トップへ
										</Link>
										<PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
												生徒登録
										</PrimaryButton>
								</div>
						</form>
				</GuestLayout>
		</AuthenticatedLayout>
</template>
