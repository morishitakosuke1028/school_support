<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const excelDownloadUrl = computed(() => `http://localhost:8000/storage/excel/import_sample.xlsx`);

const selectedFile = ref(null);
const { errors } = usePage().props;

const fileSelected = (event) => {
  selectedFile.value = event.target.files[0];
  errors.csv_file = null;
};

const storeImport = () => {
  if (!selectedFile.value) {
    errors.csv_file = "ファイルを選択してください。";
    return;
  }

  const formData = new FormData();
  formData.append('csv_file', selectedFile.value);

  router.post('/csvImport', formData, {
    onError: (err) => {
      if (err.hasOwnProperty('csv_file')) {
        errors.csv_file = err.csv_file;
      }
    }
  });
};
</script>

<template>
    <Head title="生徒情報インポート" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                生徒情報インポート
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <p class="text-red-600">■CSVのエクスポート方法</p>

                                    <p class="text-red-600">・ダウンロードしたExcelの「説明＆サンプル」のワークシートを参考にしながら、「データ入力用」のワークシートに情報を入力。</p>
                                    <p class="text-red-600">・ファイル＞名前を付けて保存＞ファイル形式を「CSV UTF-8（コンマ区切り）（*.csv）」を選択して保存。</p>
                                    <p class="text-red-600">・保存したCSVファイルをアップロード</p>
                                    <br>
                                    <p>サンプルエクセルデータのダウンロードは下記</p>
                                    <div class="p-2 w-full">
                                        <a style="padding: 10px; background-color: #87cefa; border-radius: 0.3em;" :href="excelDownloadUrl">サンプルエクセルデータダウンロード</a>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeImport">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="csv_file" class="leading-7 text-sm text-gray-600"></label>
                                                <input type="file" name="csv_file" @change="fileSelected" required>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <button type="submit" @click="fileUpload" class="flex mx-auto text-white bg-indigo-500 border-1 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">インポート</button>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
