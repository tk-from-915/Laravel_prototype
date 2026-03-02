<script setup lang="ts">
const form = useState('contactForm')

// フォームデータがなければ入力画面に戻す
if (!form.value) {
  navigateTo('/contact')
}

const handleCancel = () => navigateTo('/contact')

const handleSubmit = () => {
  // TODO: GraphQL Mutation でお問い合わせを送信する
  form.value = null
  navigateTo('/')
}
</script>

<template>
  <div id="backgroud">
    <h5 id="page_title">お問い合わせ＆採用情報</h5>
    <table id="contact_form_table">
      <tr>
        <td class="left_cell"><span class="red">＊</span>　お名前</td>
        <td class="center_cell"></td>
        <td class="right_cell">{{ form?.name }}　様</td>
      </tr>
      <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
      <tr>
        <td class="left_cell">電話番号</td>
        <td class="center_cell"></td>
        <td class="right_cell">{{ form?.tel }}</td>
      </tr>
      <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
      <tr>
        <td class="left_cell"><span class="red">＊</span>メールアドレス</td>
        <td class="center_cell"></td>
        <td class="right_cell">{{ form?.email }}</td>
      </tr>
      <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
      <tr>
        <td class="left_cell"><span class="red">＊</span>　種別</td>
        <td class="center_cell"></td>
        <td class="right_cell">{{ form?.type }}</td>
      </tr>
      <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
      <tr>
        <td class="left_cell">お問い合わせ内容</td>
        <td class="center_cell"></td>
        <td class="right_cell">{{ form?.message }}</td>
      </tr>
      <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
    </table>
    <input type="button" class="red_button cancel_button" value="Cancel" @click="handleCancel">
    <input type="button" class="green_button submit_button" value="Submit" @click="handleSubmit">
  </div>
</template>
