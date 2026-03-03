// TODO: GraphQL からカテゴリ一覧を取得する実装に差し替える
export const PRODUCT_CATEGORIES = [
  { id: 'foliage',   name: '観葉植物' },
  { id: 'succulent', name: '多肉植物' },
  { id: 'bonsai',    name: '盆栽' },
  { id: 'flower',    name: '生花' },
  { id: 'caudex',    name: '塊根植物' },
  { id: 'epiphyte',  name: '着生植物' },
  { id: 'tropical',  name: '熱帯植物' },
  { id: 'terrarium', name: 'テラリウム・パルダリウム' },
  { id: 'goods',     name: 'グッズ' },
] as const

export type CategoryId = typeof PRODUCT_CATEGORIES[number]['id']
