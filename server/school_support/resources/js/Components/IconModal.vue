<script setup>
defineProps({
  isVisible: Boolean,
  iconName: String,
});
</script>
<template>
    <div v-if="isVisible" class="modal">
      <div class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <p>クリックしたアイコン {{ iconName }}</p>
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
    padding: 20px;
    border-radius: 5px;
    width: 80%;
    max-width: 500px;
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
