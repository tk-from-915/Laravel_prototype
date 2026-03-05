<script setup lang="ts">
const savedForm = useState('contactForm')

const form = reactive({
  name:    savedForm.value?.name    ?? '',
  tel:     savedForm.value?.tel     ?? '',
  email:   savedForm.value?.email   ?? '',
  type:    savedForm.value?.type    ?? '',
  message: savedForm.value?.message ?? '',
})

const handleSubmit = () => {
  savedForm.value = { ...form }
  navigateTo('/contact/confirm')
}
</script>

<template>
  <div id="backgroud">
    <h5 id="page_title">お問い合わせ＆採用情報</h5>
    <form @submit.prevent="handleSubmit">
      <table id="contact_form_table">
        <tr>
          <td class="left_cell"><span class="red">＊</span>お名前</td>
          <td class="center_cell"></td>
          <td class="right_cell">
            <input v-model="form.name" type="text" class="contact_forms" required>
          </td>
        </tr>
        <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
        <tr>
          <td class="left_cell">電話番号</td>
          <td class="center_cell"></td>
          <td class="right_cell">
            <input v-model="form.tel" type="tel" class="contact_forms">
          </td>
        </tr>
        <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
        <tr>
          <td class="left_cell"><span class="red">＊</span>メールアドレス</td>
          <td class="center_cell"></td>
          <td class="right_cell">
            <input v-model="form.email" type="email" class="contact_forms" required>
          </td>
        </tr>
        <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
        <tr>
          <td class="left_cell"><span class="red">＊</span>　種別</td>
          <td class="center_cell"></td>
          <td class="right_cell">
            <select v-model="form.type" class="contact_forms" required>
              <option value="">お問い合わせ内容をお選びください</option>
              <option value="商品">商品に関するお問い合わせ</option>
              <option value="店舗">店舗に関するお問い合わせ</option>
              <option value="採用情報">採用情報に関するお問い合わせ</option>
              <option value="その他">その他</option>
            </select>
          </td>
        </tr>
        <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
        <tr>
          <td class="left_cell">お問い合わせ内容</td>
          <td class="center_cell"></td>
          <td class="right_cell">
            <textarea v-model="form.message" rows="10" cols="54" maxlength="500"></textarea>
          </td>
        </tr>
        <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
      </table>
      <CommonAppButton type="submit" class="button-margin">お問い合わせ内容確認</CommonAppButton>
    </form>
  </div>
</template>

<style scoped>
.button-margin {
  margin: 0px auto 30px;
  font-size: 16px;
}
</style>
