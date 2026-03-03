<template>
  <AuthPageWrapper title=":Reset Password page" action-label="Login" action-to="/login">
    <h2 class="auth-title">Reset Password</h2>

    <form class="auth-card" @submit.prevent="handleReset">
      <div class="auth-field">
        <label class="auth-field__label">E-Mail Address</label>
        <input v-model="email" type="email" class="auth-field__input" required />
      </div>

      <button type="submit" class="auth-btn">
        Send Password<br />Reset Link
      </button>
    </form>
  </AuthPageWrapper>
</template>

<script setup lang="ts">
definePageMeta({ layout: false })

const email = ref('')

function handleReset() {
  // TODO: パスワードリセットメールを送信する
  alert('パスワードリセットリンクを送信しました。')
  navigateTo('/login')
}
</script>

<style lang="scss" scoped>
.auth-title {
  font-size: 26px;
  font-weight: bold;
  color: $primary;
  margin-bottom: 20px;
  text-align: center;
}

.auth-card {
  width: 400px;
  background-color: #efefef;
  padding: 32px 40px 36px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.auth-field {
  width: 100%;
  margin-bottom: 24px;

  &__label {
    display: block;
    font-size: 13px;
    color: $text-muted;
    margin-bottom: 6px;
    text-align: center;
  }

  &__input {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    font-size: 15px;
    box-sizing: border-box;

    &:focus {
      outline: none;
      border-color: $primary;
    }
  }
}

.auth-btn {
  width: 200px;
  height: 140px;
  background-color: rgba($primary, 0.5);
  color: #fff;
  font-size: 18px;
  font-weight: bold;
  line-height: 1.5;
  border: none;
  cursor: pointer;
  transition: background-color 0.15s;
  text-align: center;

  &:hover {
    background-color: rgba($primary, 0.65);
  }
}
</style>
