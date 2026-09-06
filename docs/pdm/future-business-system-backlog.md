---
pdm_version: "0.1"
id: taguchi-future-business-system-backlog
name: 将来業務システム構想バックログ
slug: future-business-system
type: planning.backlog
status: active
created_at: 2026-09-06
updated_at: 2026-09-06
owners:
  - a-a-d-d
relations:
  - type: informed_by
    target: taguchi-scope-reduction-decision
  - type: related_to
    target: taguchi-system-roadmap
---

# 将来業務システム構想バックログ

## Purpose

初期Proposalで設計した広い業務システム構想を、現行MVPと混同せず、将来提案のための設計資産として保持します。

ここに記載される項目は「不要」と判断されたものではありません。一方で、現時点では確定要求でも実装予定でもありません。関係者への要求確認と業務上の必要性確認を経て、採用する項目だけをRoadmap、Milestone、PlanまたはSpecificationへ昇格させます。

原資料は `docs/proposal/` に保存します。

## Items

### `future-general-credit-order-platform`

- status: candidate
- title: 一般注文・買掛注文を扱う注文基盤
- source: `docs/proposal/00_summary.md` ほか
- intent: EC的な商品選択と、取引条件に応じた注文経路を統合する構想です。

### `future-site-order-management`

- status: candidate
- title: 現場別発注管理
- source: 初期Proposal
- intent: 発注を現場単位で追跡・集計できるようにする構想です。

### `future-approval-workflow`

- status: candidate
- title: 承認フロー
- source: 初期Proposal
- intent: 発注権限と承認経路をシステム上で管理する構想です。

### `future-order-history`

- status: candidate
- title: 発注・注文履歴管理
- source: 初期Proposal
- intent: 過去の発注を検索・追跡し、属人化を軽減する構想です。

### `future-cost-management`

- status: candidate
- title: 現場別原価管理
- source: 初期Proposal
- intent: 現場別の発注量・原価・商品内訳・月次集計を可視化する構想です。

### `future-permissions`

- status: candidate
- title: 権限管理
- source: `docs/proposal/06_permissions.md`
- intent: 利用者の役割に応じた操作・閲覧範囲を管理する構想です。

### `future-price-history`

- status: candidate
- title: 価格履歴管理
- source: 初期Proposal
- intent: 商品価格の改定履歴を追跡可能にする構想です。

### `future-management-dashboard`

- status: candidate
- title: 管理ダッシュボード・集計出力
- source: 初期Proposal
- intent: 発注・原価・承認・納品等の状況を管理側から可視化し、CSV等へ出力する構想です。

### `future-supplier-portal`

- status: candidate
- title: 発注先・仕入先ポータル
- source: 初期Proposal Phase 2
- intent: 本社から仕入先への発注、納期回答、出荷登録等をオンライン連携する構想です。

### `future-inventory-accounting-bi`

- status: candidate
- title: 在庫・会計・BI連携
- source: 初期Proposal Phase 2
- intent: 発注データを周辺業務システムや分析基盤へ接続する構想です。

### `future-fax-api`

- status: candidate
- title: FAX API連携
- source: 初期Proposal Phase 2
- intent: FAXを完全廃止できない取引先等との境界をAPI化する構想です。

## Promotion Rules

各項目は、次の条件を満たした場合にのみ実装対象へ昇格します。

1. 対象業務の責任者・利用者から具体的な課題または要求が確認できること。
2. 現行MVPまたは実運用の観察から、導入効果または必要性を説明できること。
3. 業務フロー、責任境界、データauthorityが確認できること。
4. 対象範囲と受入条件をSpecificationまたはPlanとして定義できること。

旧Proposalに記載されていることだけを理由に、candidate項目を実装へ昇格させてはいけません。
