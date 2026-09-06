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

現在はM1「提示用オンライン発注MVP」の**Repository実装完了、実環境統合検証前**です。

現行MVPの正本である「発注フォーム → 本社メール + PDF発注書」について、既存Contact Form 7の `purchase-order_form` を入口として再利用し、メール送信時に同じ入力データからPDFを生成・添付する実装を追加しました。

M1を完了扱いにはまだしません。実サーバー上で代表発注を送信し、メール受信・PDF内容・日本語表示・UIを確認する必要があります。

## Achieved Capabilities

Repository上で実装・検証済みの内容:

- 既存の発注専用CF7フォーム `purchase-order_form` をMVP入力経路として特定した。
- EC / WooCommerce checkoutをMVP実装経路から分離した。
- 発注受付処理をテーマではなくproject MU pluginへ分離した。
- 発注時に受付番号を発行する処理を追加した。
- CF7送信データをmPDFへ渡し、日本語/CJK対応のA4発注書PDFを生成する処理を追加した。
- 生成PDFをCF7管理メールへ添付する処理を追加した。
- PDF生成失敗時はメールだけを送らず、送信自体を中断するfail-closed動作とした。
- 発注ページをsemantic classで再構成した。
- CSS抽象化レイヤーの下位frameworkとしてTailwind CSS 4.3.3を導入した。
- Tailwind Preflightは既存WordPressテーマへの影響を避けるため無効化した。
- Tailwind生成物、npm lock、Composer lockをCIで確定する経路を追加した。
- PHP構文、Tailwind build、Composer定義、mPDF installationをGitHub Actionsで検証した。
- デプロイスクリプトを新Repository slugへ更新し、MU plugin + Composer依存を配布できる構成へ拡張した。

## Stakeholder Impact

提示用MVPは、旧ProposalのEC全体を完成させなくても成立する状態になりました。

次の実環境確認で、現場担当者が既存のWeb発注フォームを入力し、本社側がメールとPDF発注書を受け取る一連の体験を確認できます。

UIも既存テーマを全面改修せず、発注画面から段階的にモダン化できる基盤になっています。

## Remaining

M1完了までの必須確認:

- 検証環境へbranchをデプロイする。
- 実際のCF7フォームフィールド名とPDFの表示ラベルを照合する。
- 代表発注を送信する。
- 本社向けメールが受信できることを確認する。
- メール件名に受付番号が付与されることを確認する。
- PDFがメールに添付されることを確認する。
- PDFの日本語・改行・項目順・A4レイアウトを目視確認する。
- メール内容とPDF内容が同一発注データであることを確認する。
- desktop / mobileで発注フォーム、確認、完了、validation errorのUIを目視確認する。
- 実環境で問題がなければM1完了としてPRをmainへ統合する。

M1必須ではないもの:

- 受注用PCへのPDF自動保存
- 自動印刷
- 受付履歴管理
- WooCommerce / ECの完成
- 承認・原価管理・管理ダッシュボード

## Evidence

Repository evidence:

- `wp-content/themes/taguchi_system/page-purchase-order.php`
- `wp-content/themes/taguchi_system/assets/src/order-ui.css`
- `wp-content/themes/taguchi_system/assets/css/order-ui.css`
- `wp-content/mu-plugins/taguchi-order-mvp.php`
- `wp-content/mu-plugins/taguchi-order-mvp/bootstrap.php`
- `wp-content/mu-plugins/taguchi-order-mvp/composer.json`
- `wp-content/mu-plugins/taguchi-order-mvp/composer.lock`
- `package.json`
- `package-lock.json`
- `.github/workflows/mvp-check.yml`
- `scripts/deploy-xserver.sh`
- `docs/pdm/order-digitization-spec.md`
- `docs/pdm/mvp-implementation-plan.md`
- `Period-Inc/Codes/docs/development-policy.md`

Verification evidence:

- GitHub Actions `MVP Check`: Tailwind build success
- GitHub Actions `MVP Check`: Composer validation / mPDF installation success
- GitHub Actions `MVP Check`: PHP syntax checks success

このレポートはRepository/CI上の実装状態を表します。実ブラウザ、実メール配送、実PDFの受入確認はまだM1の未完了条件として残します。
