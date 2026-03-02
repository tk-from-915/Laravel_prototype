<script setup lang="ts">
const form = reactive({
  name: '',
  tel: '',
  email: '',
  type: '',
  message: '',
})

const handleSubmit = () => {
  // 確認画面へ state を渡して遷移
  useState('contactForm').value = { ...form }
  navigateTo('/contact/confirm')
}
</script>

<template>
  <div id="backgroud">
    <h5 id="page_title">お問い合わせ＆採用情報</h5>
    <form @submit.prevent="handleSubmit">
      <table id="contact_form_table">
        <tr>
          <td class="left_cell"><span class="red">＊</span>　お名前</td>
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
              <option value="問い合わせ1">1、商品・店舗に関するお問い合わせ</option>
              <option value="問い合わせ2">２、採用情報に関するお問い合わせ</option>
              <option value="問い合わせ3">3、その他</option>
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
      <input type="submit" class="green_button confirm_button" value="確認する">
    </form>
  </div>
</template>
