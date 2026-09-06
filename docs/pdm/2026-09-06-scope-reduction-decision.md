---
pdm_version: "0.1"
id: taguchi-scope-reduction-decision
name: 要求確認前の過剰実装を避け、MVPを発注受付に限定する決定
slug: scope-reduction
type: architecture.decision
status: active
created_at: 2026-09-06
updated_at: 2026-09-06
owners:
  - a-a-d-d
relations:
  - type: informs
    target: taguchi-system-roadmap
  - type: related_to
    target: taguchi-order-digitization-spec
  - type: related_to
    target: taguchi-future-business-system-backlog
---

# 要求確認前の過剰実装を避け、MVPを発注受付に限定する決定

## Context

初期の提案では、建材EC、一般注文・買掛注文、現場別発注、承認、原価管理、履歴、ダッシュボード、仕入先連携などを含む広い業務システム構想を設計しました。

その後、この広い範囲について元請け・関係者の意思確認が十分にできておらず、確定要求として実装を進める根拠が不足していることが判明しました。

一方で、現場から本社への発注がFAX・電話中心であること、およびその入口をオンライン化したいという要求は明確です。

## Decision

現行MVPは、次の範囲へ限定します。

- 現場からWebフォームで発注する。
- 本社へメールで通知する。
- 同じ発注内容からPDFを生成する。
- 本社では既存の受注工程を継続利用する。

必要に応じ、既存工程との接続を滑らかにする範囲で、PDFの受注用PCへの自動保存と自動印刷を追加できます。

初期Proposalで設計した広い業務システム構想は破棄しません。ただし、現行要求または実装予定としては扱わず、将来の要求確認・提案材料として保存します。

## Consequences

### 利点

- 未確認要求を前提とした過剰実装を避けられます。
- 現在確認できている業務課題に対して、短い経路で価値を提供できます。
- 既存の本社業務を大きく変えずに導入できます。
- 旧Proposalの調査・設計資産は将来提案へ再利用できます。

### 制約

- 原価管理、承認、分析、仕入先連携などの効果はMVPでは得られません。
- 将来の拡張時には、利用者・業務責任者・元請け等への要求確認が改めて必要です。
- 旧Proposalの記載は現行仕様と一致しないため、実装判断のauthorityとして参照してはいけません。

### 文書運用

- 現行仕様のauthorityはPDM管理文書に置きます。
- `docs/proposal/` は初期提案時点の原稿・検討資産として保持します。
- 旧Proposalにある機能を実装候補へ戻す場合は、要求確認結果を根拠としてRoadmapまたはPlanへ昇格させます。
