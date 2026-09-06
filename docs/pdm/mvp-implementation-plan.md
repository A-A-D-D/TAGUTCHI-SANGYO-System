---
pdm_version: "0.1"
id: taguchi-mvp-implementation-plan
name: 発注オンライン化 MVP 実装計画
slug: mvp-implementation
type: planning.plan
status: active
created_at: 2026-09-06
updated_at: 2026-09-06
owners:
  - a-a-d-d
relations:
  - type: implements
    target: taguchi-order-digitization-spec
  - type: depends_on
    target: taguchi-scope-reduction-decision
  - type: related_to
    target: taguchi-system-roadmap
  - type: related_to
    target: taguchi-ui-css-architecture-decision
---

# 発注オンライン化 MVP 実装計画

## Objective

2026-09-07〜2026-09-13の週に、数時間の集中作業で提示可能なMVPへ到達します。

現場から本社への発注を、Webフォーム → メール通知 + PDF生成の経路で成立させます。旧Proposal由来のEC機能を完成させることは目的にしません。

## Scope

必須:

- 発注フォーム
- 必須入力検証
- 発注受付識別子
- 本社向けメール通知
- 発注書PDF生成
- メールとPDFの内容一致
- 代表ケースの動作確認
- 提示可能なUI品質

UI/CSS:

- `Period-Inc/Codes` のCSS資産化ポリシーに従う
- Tailwind CSSを導入する
- Tailwindを直接の設計言語にせず、semantic / component / layout等の抽象化レイヤーを置く
- 既存CSS全面置換ではなく、MVP対象画面から段階移行する

対象外:

- EC完成
- 決済
- 本格的注文管理
- 承認フロー
- 原価管理
- 管理ダッシュボード
- 在庫・配送管理

## Steps

1. **現行経路の確認** — 発注に関係する既存テンプレート、functions、WooCommerce hooks、フォーム処理を特定する。
2. **最短経路を選ぶ** — 既存実装を流用する方が速い部分と、現行MVP用に切り出す部分を分ける。
3. **フォームを成立させる** — 必須項目、入力検証、受付IDを実装する。
4. **メールを成立させる** — 本社向け通知の件名・本文・宛先設定を実装する。
5. **PDFを成立させる** — 同じ入力モデルから発注書PDFを生成し、メールとの内容差異を防ぐ。
6. **UI基盤を入れる** — Tailwind buildを追加し、MVP画面向けsemantic/component layerを構成する。
7. **UIを整える** — フォーム、確認、完了、エラー状態を現代的で業務利用に違和感のないUIへ調整する。
8. **代表ケースを通す** — 入力 → 送信 → メール → PDFを一連で確認する。
9. **提示準備** — 既知制約と将来候補を切り分けた状態で提示する。

## Dependencies

- 通知先メールアドレス
- 発注書に必要な項目・様式
- WordPress実環境のメール送信可否
- PDF生成に利用可能な既存依存または導入可能なライブラリ
- 既存テーマCSSとの競合範囲

要求が未確定な細部は、MVP提示を阻害しない安全な暫定値・設定可能値として扱い、ハードコードで恒久仕様化しません。

## Completion

以下を満たした時点でMVP提示可能とします。

- 代表的な発注をWebフォームから正常送信できる。
- 本社側で該当発注のメールを受信できる。
- 同じ発注に対応するPDFを取得できる。
- メールとPDFの主要内容が一致する。
- エラー時に利用者へ適切な状態が示される。
- PC/モバイルで発注操作に大きなUI崩れがない。
- Tailwindのutilityが無秩序にテンプレートへ散在せず、プロジェクト側の抽象化境界がある。
- MVP対象外の旧Proposal機能を完成済みと誤認させない。
