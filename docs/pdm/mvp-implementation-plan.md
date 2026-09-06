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

## Scope

対象は現行仕様 `taguchi-order-digitization-spec` のMVP範囲です。

- 発注フォーム
- 入力検証
- 発注受付識別子
- 本社向けメール通知
- 発注書PDF生成
- 受付・送信・PDF生成を追跡できる記録
- 本社側での受領確認

追加可能範囲として、受注用PCへのPDF自動保存・自動印刷を扱います。ただし受注端末側の環境条件確認を前提とします。

## Steps

1. 現在の発注フォーム項目と入力経路を確認し、不足・不要項目を整理する。
2. 発注受付時の識別子と保存内容を確定する。
3. メール通知の宛先、件名、本文、失敗時挙動を確定する。
4. PDF様式とメール内容との整合を確認する。
5. 代表的な発注パターンでフォーム → メール → PDFの一連動作を検証する。
6. 本社側が受領した情報を既存業務へ引き継げることを確認する。
7. 必要な場合、受注用PCへのPDF自動保存・印刷方式を実環境に合わせて設計・検証する。
8. MVP受入後、運用で観測された課題をRoadmapまたはBacklogへ反映する。

## Dependencies

- 現場で実際に必要な発注項目の確認
- 本社側の通知先メールアドレス・運用
- 発注書PDFの必要項目・帳票様式
- WordPress / WooCommerce側の現行実装と利用プラグイン
- 自動保存・自動印刷を行う場合は受注用PC、OS、ネットワーク、プリンタの条件

## Completion

以下を満たしたとき、本PlanのMVP主要部分を完了とします。

- 代表的な発注をWebフォームから正常送信できる。
- 本社側で該当発注のメールを受信できる。
- 同じ発注に対応するPDFを取得・確認できる。
- メールとPDFの主要発注内容が一致する。
- 発注受付から本社の既存受注工程へ引き継げる。
- 異常時に受付・メール・PDF生成のどこで失敗したか調査可能である。

PDF自動保存・自動印刷は、導入すると判断した場合のみ別途完了条件へ追加します。
