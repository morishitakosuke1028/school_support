<script setup>
defineProps({
  isVisible: Boolean,
  iconName: String,
});
</script>
<template>
    <div v-if="isVisible" class="modal">
      <div v-if="iconName === 'attendance'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">登校一覧機能（出席簿）</h3>
            <p class="text-gray-300 text-md">こちらは出席簿を一括で登録する機能となります。保護者様からの申請を自動で反映致します。</p>
            <div class="md:flex">
                <p><img src="images/attendance-child.png" alt=""><span class="text-xs text-gray-300">保護者サイト</span></p>
                <p><img src="images/attendance-register.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'child'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">生徒関連の機能</h3>
            <p class="text-gray-300 text-md">生徒の登録、編集などを行なえます。また登録した情報は保護者様のログイン時に使用できます。</p>
            <div class="md:flex">
                <p><img src="images/child-register.png" alt=""><span class="text-xs text-gray-300">保護者サイト</span></p>
                <p><img src="images/child-index.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'staff'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">職員関連の機能</h3>
            <p class="text-gray-300 text-md">職員の登録、編集などを行なえます。また登録した情報は職員様のログイン時に使用できます。</p>
            <div class="md:flex">
                <p><img src="images/staff-register.png" alt=""></p>
                <p><img src="images/staff-index.png" alt=""></p>
            </div>
        </div>
      </div>
    </div>
</template>
<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    background-color: #fff;
    padding: 50px;
    border-radius: 5px;
    width: 100%;
    max-width: 80em;
    z-index: 1001;
}

.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 25px;
    font-weight: bold;
    color: #000;
    cursor: pointer;
}
</style>
