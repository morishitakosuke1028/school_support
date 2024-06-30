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
            <p class="text-gray-300 text-md my-2">こちらは出席簿を一括で登録する機能となります。保護者様からの申請を自動で反映致します。</p>
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
            <p class="text-gray-300 text-md my-2">生徒の登録、編集などを行なえます。また登録した情報は保護者様のログイン時に使用できます。</p>
            <div class="md:flex">
                <p><img src="images/child-register.png" alt=""></p>
                <p><img src="images/child-index.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'staff'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">職員関連の機能</h3>
            <p class="text-gray-300 text-md my-2">職員の登録、編集などを行なえます。また登録した情報は職員様のログイン時に使用できます。</p>
            <div class="md:flex">
                <p><img src="images/staff-register.png" alt=""></p>
                <p><img src="images/staff-index.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'csvimport'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">生徒のCSVインポート</h3>
            <p class="text-gray-300 text-md my-2">生徒の一括登録を行なえます。また登録した情報は生徒一覧で確認できます。</p>
            <div class="md:flex">
                <p><img src="images/csv-import-create.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'gradeclass'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">学年クラス作成</h3>
            <p class="text-gray-300 text-md my-2">学年クラス登録、編集を行なえます。また登録した情報でクラス替え、宿題マスタの作成などと連携できます。</p>
            <div class="md:flex">
                <p><img src="images/create-c.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'change'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">クラス替え機能</h3>
            <p class="text-gray-300 text-md my-2">登録した生徒をクラスに一括登録することができます。</p>
            <div class="md:flex">
                <p><img src="images/change-pc.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'contact'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">連絡帳機能</h3>
            <p class="text-gray-300 text-md my-2">職員、保護者間で連絡することができます。また保護者側では簡易認証を用いています。</p>
            <div class="md:flex">
                <p><img src="images/contact-child.png" alt=""></p>
                <p><img src="images/contact-pc.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'event'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">行事管理機能</h3>
            <p class="text-gray-300 text-md my-2">職員、保護者間で行事予定の管理ができます。カレンダー形式で使い勝手に優れています。</p>
            <div class="md:flex">
                <p><img src="images/event-child.png" alt=""></p>
                <p><img src="images/event-pc.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'homework'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">宿題管理機能</h3>
            <p class="text-gray-300 text-md my-2">職員、生徒間で宿題の情報の共有ができます。</p>
            <div class="md:flex">
                <p><img src="images/homework-child.png" alt=""></p>
                <p><img src="images/homework-pc.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'graph'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">成長記録機能</h3>
            <p class="text-gray-300 text-md my-2">グラフ化された成長曲線を表示することができます。</p>
            <div class="md:flex">
                <p><img src="images/growth-child.png" alt=""></p>
                <p><img src="images/growth-pc.png" alt=""></p>
            </div>
        </div>
      </div>
      <div v-if="iconName === 'schedule'" class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <div class="mx-auto my-auto">
            <h3 class="font-bold">時間割機能</h3>
            <p class="text-gray-300 text-md my-2">好きな名前の教科を作成して時間割を作成できます。</p>
            <div class="md:flex">
                <p><img src="images/subject-index.png" alt=""></p>
                <p><img src="images/schedule-index.png" alt=""></p>
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
