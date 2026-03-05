<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const form = useState('contactForm')

if (!form.value) {
  navigateTo('/contact')
}

const SUBMIT_CONTACT = gql`
  mutation SubmitContact(
    $name: String!
    $tel: String
    $email: String!
    $type: String!
    $message: String!
  ) {
    submitContact(name: $name, tel: $tel, email: $email, type: $type, message: $message) {
      id
    }
  }
`

const { mutate: submitContact, loading } = useMutation(SUBMIT_CONTACT)
const error = ref('')

const handleCancel = () => navigateTo('/contact')

const handleSubmit = async () => {
  error.value = ''
  try {
    await submitContact({
      name:    form.value.name,
      tel:     form.value.tel || null,
      email:   form.value.email,
      type:    form.value.type,
      message: form.value.message,
    })
    form.value = null
    navigateTo('/contact/complete')
  } catch {
    error.value = '送信に失敗しました。時間をおいてもう一度お試しください。'
  }
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
      <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_effect"></td></tr>
      <tr>
        <td class="left_cell"><span class="red">＊</span>メールアドレス</td>
        <td class="center_cell"></td>
        <td class="right_cell">{{ form?.email }}</td>
      </tr>
      <tr><td class="left_cell"></td><td class="center_cell"></td><td class="right_cell"></td></tr>
      <tr>
        <td class="left_cell"><span class="red">＊</span>種別</td>
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
    <p v-if="error" class="error-text">{{ error }}</p>
    <div class="button-row">
      <CommonAppButton
        variant="red"
        :disabled="loading"
        @click="handleCancel"
        class="button"
      >
        戻る
      </CommonAppButton>
      <CommonAppButton
        :disabled="loading"
        @click="handleSubmit"
        class="button"
      >
        {{ loading ? '送信中...' : '送信' }}
      </CommonAppButton>
    </div>
  </div>
</template>

<style scoped>
.error-text {
  color: #e05252;
  text-align: center;
  margin: 12px 0;
  font-size: 14px;
}

.button-row {
  display: flex;
  justify-content: space-between;
  margin: 0px 15% 40px;
}
.button {
  font-size: 16px;
}
</style>
