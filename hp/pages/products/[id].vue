<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { id } = useRoute().params as { id: string }

const GET_PRODUCT = gql`
  query GetProduct($id: ID!) {
    product(id: $id) { id name description price categories { name } }
  }
`

const { result, loading } = useQuery(GET_PRODUCT, { id })
const product = computed(() => result.value?.product ?? null)

const showCommentForm = ref(true)
const comment = reactive({ name: '', body: '' })

const submitComment = () => {
  // TODO: コメント送信 API が実装されたら接続する
  comment.name = ''
  comment.body = ''
}
</script>

<template>
  <div id="backgroud">
    <div id="post_archive">
      <div v-if="loading" class="loading-text">読み込み中...</div>
      <template v-else-if="product">
        <h5 id="news_blog_title">{{ product.name }}</h5>
        <p v-if="product.price != null" class="product-price">¥{{ product.price.toLocaleString() }}</p>
        <p v-if="product.categories.length > 0" class="product-categories">
          {{ product.categories.map((c: any) => c.name).join(' / ') }}
        </p>
        <div v-if="product.description" class="post_content" v-html="product.description"></div>

        <div id="comment_area">
          <p class="center">みなさんのコメント</p>
          <button class="green_button comment_more">More  →</button>

          <div v-if="showCommentForm" id="comment_edit_area">
            <h5 class="green">Comments</h5>
            <table id="comment_table">
              <tr>
                <td class="left_cell">ハンドルネーム</td>
                <td class="center_cell"></td>
                <td class="right_cell">
                  <input v-model="comment.name" type="text" class="comment_form">
                </td>
              </tr>
              <tr>
                <td class="left_cell">コメント</td>
                <td class="center_cell"></td>
                <td class="right_cell">
                  <textarea v-model="comment.body" rows="7" cols="40" maxlength="120" class="comment_form"></textarea>
                </td>
              </tr>
            </table>
            <button id="comment_submit" class="green_button" @click="submitComment">コメントする</button>
          </div>
        </div>
      </template>
      <p v-else class="loading-text">商品が見つかりません。</p>
    </div>
  </div>
</template>

<style scoped>
.loading-text {
  text-align: center;
  padding: 40px;
  color: #a8a8a8;
}

.product-price {
  font-size: 20px;
  color: #007575;
  font-weight: bold;
  margin: 8px 0;
}

.product-categories {
  font-size: 14px;
  color: #a8a8a8;
  margin-bottom: 16px;
}
</style>
