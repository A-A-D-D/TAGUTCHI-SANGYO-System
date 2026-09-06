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
---

# 発注オンライン化 MVP 実装計画

## Objective

現場から本社への発注を、Webフォーム → メール通知 + PDF生成の経路で成立させ、既存の受注工程へ確実に引き継げる状態にします。

来週の提示では、旧Proposalに含まれるEC全体を完成させることではなく、代表発注を実際に送信し、本社側でメールとPDFを受領できる一連の体験を提示できることを優先します。

## Scope

MVP対象:

- 既存Contact Form 7 `purchase-order_form` を利用した発注入力
- 入力検証
- 発注受付識別子
- 本社向けメール通知
- 同じ入力データからの発注書PDF生成
- PDFの管理メール添付
- PDF生成失敗時にメール単独送信を許可しないfail-closed動作
- 発注画面の提示品質までのUI調整
- desktop / mobileでの表示確認

UI/CSS:

- `Period-Inc/Codes` のCSS資産化方針を上位規範とする。
- templateはsemantic classを使用し、framework utilityを直接散在させない。
- semantic/component abstraction layerの実装frameworkとしてTailwind CSS 4.3.3を使用する。
- 既存WordPressテーマへ段階導入するためTailwind Preflightは使用しない。

MVP対象外:

- WooCommerce checkout完成
- EC一般注文・買掛注文
- 決済
- 本格注文管理
- 承認フロー
- 原価管理
- 管理ダッシュボード
- 在庫・配送管理

追加可能範囲として、受注用PCへのPDF自動保存・自動印刷を扱います。ただしM1提示の必須条件にはしません。

## Steps

### Repository implementation — completed

1. 既存実装を監査し、発注専用CF7フォームをMVP入口として特定する。
2. 発注ページをsemantic UI構造へ整理する。
3. Tailwind buildとcomponent abstraction layerを導入する。
4. 発注受付処理をproject MU pluginへ分離する。
5. 発注受付番号を生成する。
6. CF7送信データからmPDFでA4発注書を生成する。
7. 生成PDFを管理メールへ添付する。
8. PDF生成失敗時は送信を中断する。
9. npm / Composer依存とlockを確定する。
10. CIでTailwind build、Composer、mPDF、PHP構文を検証する。
11. deploy scriptをテーマ + MVP MU plugin配布へ拡張する。

### Runtime acceptance — remaining

12. 検証環境へbranchをデプロイする。
13. 実CF7フォームのfield nameとPDF表示ラベルを照合する。
14. 代表発注を送信し、メール受信・受付番号・PDF添付を確認する。
15. PDFの日本語、項目、改行、A4レイアウトを目視確認する。
16. desktop / mobileで入力、確認、完了、validation errorを確認する。
17. 問題を修正し、再度代表発注を通す。
18. M1受入後、PRをmainへ統合する。

## Dependencies

- Contact Form 7 6.1.6
- `purchase-order_form` の実環境設定
- 本社側の通知先メール設定
- PHP 7.4以上
- PHP extensions: mbstring, gd
- mPDF 8.3.1（Composerで管理）
- Tailwind CSS 4.3.3（build-time dependency）
- 検証環境へのデプロイ権限

## Completion

以下を満たしたときM1を完了とします。

- 代表的な発注をWebフォームから正常送信できる。
- 本社側で該当発注のメールを受信できる。
- メール件名等から受付番号を識別できる。
- 同じ発注に対応するPDFがメール添付される。
- メールとPDFの主要発注内容が一致する。
- PDFの日本語が正常に表示される。
- 発注受付から本社の既存受注工程へ引き継げる。
- PDF生成等の異常時に、正常受付と誤認するメールが送信されない。
- desktop / mobileで提示に耐えるUIになっている。

PDF自動保存・自動印刷は、導入すると判断した場合のみM2の完了条件として扱います。
