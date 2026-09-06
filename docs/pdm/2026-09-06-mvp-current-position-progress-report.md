---
pdm_version: "0.1"
id: taguchi-mvp-current-position-progress-report
name: MVP現在地レポート
slug: mvp-current-position
type: reporting.progress
status: active
created_at: 2026-09-06
updated_at: 2026-09-06
owners:
  - a-a-d-d
relations:
  - type: reports_on
    target: taguchi-system-roadmap
  - type: reports_on
    target: taguchi-mvp-implementation-plan
  - type: evidenced_by
    target: taguchi-order-digitization-spec
---

# MVP現在地レポート

## Roadmap Position

現在はM0「現在地確定」からM1「提示用オンライン発注MVP」へ移る直前です。

RepositoryにはWordPressカスタムテーマ `taguchi_system` があり、WooCommerce向けの商品、カート、チェックアウト等の画面骨格も存在します。一方、現行MVPの正本はEC完成ではなく「発注フォーム → 本社メール + PDF発注書」です。

Repository上の確認では、現行MVPの一連経路が完成・検証済みである証拠は確認できていません。したがってM1達成済みとは判定しません。

## Achieved Capabilities

現時点で確認できる資産:

- WordPressカスタムテーマの基盤がある。
- 既存ページテンプレート、header/footer、functions等があり、ゼロからサイトを構築する状態ではない。
- WooCommerce向け画面骨格があるため、旧ProposalのEC構想を将来再利用できる余地がある。
- 現行MVPと将来ProposalのauthorityがPDM上で分離された。
- MVP提示に向けた実装順序とUI/CSS方針が決定された。

## Stakeholder Impact

次の作業では旧EC全体を完成させる必要がなく、現場から本社への発注受付に集中できます。

これにより、短い作業時間を「フォーム・メール・PDF・提示用UI」という実際に確認してもらう価値がある経路へ集中できます。

## Remaining

M1までの主要残作業:

- 発注に関係する既存コード経路の特定
- MVP用入力モデルの確定
- フォーム入力・検証
- 本社メール通知
- PDF生成
- メール/PDFの同一データ化
- Tailwind build導入
- semantic/component CSS layer構築
- フォーム、確認、完了、エラーUI調整
- 代表ケースでの一連動作確認

追加候補だがM1必須ではないもの:

- 受注用PCへのPDF自動保存
- 自動印刷
- 受付履歴管理

## Evidence

確認根拠:

- `wp-content/themes/taguchi_system/`
- `wp-content/themes/taguchi_system/functions.php`
- `wp-content/themes/taguchi_system/page-cart.php`
- `wp-content/themes/taguchi_system/page-checkout.php`
- `docs/audit/current-state.md`
- `docs/pdm/order-digitization-spec.md`
- `docs/pdm/mvp-implementation-plan.md`
- `Period-Inc/Codes/docs/development-policy.md`

このレポートは実ブラウザ・実サーバーでのE2E確認結果ではなく、Repository上の実装監査に基づく現在地です。
