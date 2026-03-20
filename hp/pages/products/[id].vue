<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { id } = useRoute().params as { id: string }

const GET_PRODUCT = gql`
  query GetProduct($id: ID!) {
    product(id: $id) { id name description price categories { name } }
  }
`

const GET_COMMENTS = gql`
  query GetProductComments($productId: ID!) {
    productComments(productId: $productId, status: "approved") {
      id name body created_at
    }
  }
`

const CREATE_COMMENT = gql`
  mutation CreateComment($productId: ID!, $name: String!, $body: String!) {
    createComment(productId: $productId, name: $name, body: $body) {
      id
    }
  }
`

const { result, loading } = useQuery(GET_PRODUCT, { id })
const product = computed(() => result.value?.product ?? null)

const { result: commentsResult, refetch: refetchComments } = useQuery(GET_COMMENTS, { productId: id })
const comments = computed(() => commentsResult.value?.productComments ?? [])

const { mutate: createComment, loading: submitting } = useMutation(CREATE_COMMENT)

const showCommentForm = ref(true)
const submitted = ref(false)
const comment = reactive({ name: '', body: '' })
const submitError = ref('')

const submitComment = async () => {
  submitError.value = ''
  try {
    await createComment({ productId: id, name: comment.name, body: comment.body })
    comment.name = ''
    comment.body = ''
    submitted.value = true
    showCommentForm.value = false
  } catch {
    submitError.value = '送信に失敗しました。時間をおいてもう一度お試しください。'
  }
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

          <div v-if="comments.length > 0">
            <div v-for="c in comments" :key="c.id" class="comment_group">
              <img src="/images/hukidashi.jpeg" class="hukidashi" alt="" />
              <div class="commenter">{{ c.name }}</div>
              <div class="comment">{{ c.body }}</div>
            </div>
          </div>
          <p v-else class="no_comment">まだコメントはありません</p>

          <div v-if="submitted" class="comment_thanks">
            <p>コメントありがとうございます。チェック後公開されます。</p>
          </div>

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
            <p v-if="submitError" class="submit_error">{{ submitError }}</p>
            <CommonAppButton variant="green" :disabled="submitting" @click="submitComment" class="comment_submit_btn">
              {{ submitting ? '送信中...' : 'コメントする' }}
            </CommonAppButton>
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

.comment_group {
  position: relative;
  margin: 45px auto;
}

.hukidashi {
  position: absolute;
  top: -20px;
  left: -17px;
}

.commenter {
  position: absolute;
  top: -25px;
  left: 60px;
}

.comment {
  font-size: 18px;
  background-color: #E8FDF8;
  padding: 10px 5px 5px 30px;
}

.no_comment {
  text-align: center;
  color: #a8a8a8;
  margin: 8px 0;
  font-size: 14px;
}

.comment_thanks {
  text-align: center;
  color: #007575;
  font-weight: bold;
  margin: 16px 0;
  padding: 12px;
  border: 1px solid #007575;
  border-radius: 4px;
}

.submit_error {
  color: #e05252;
  font-size: 14px;
  margin: 8px 0;
}

.comment_submit_btn {
  font-size: 16px;
}
</style>
