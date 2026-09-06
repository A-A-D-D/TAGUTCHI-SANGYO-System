# TAGUTCHI-SANGYO-System

田口産業の発注業務オンライン化プロジェクトです。

## Documentation authority

本Repositoryのプロジェクト文書は Project Documentation Model (PDM) に準拠して管理します。

このプロジェクトでは、日本語をcanonical documentation languageとして扱います。

現行の要求・判断・計画については `docs/pdm/` をauthorityとします。

- `docs/pdm/order-digitization-spec.md` — 現行MVPの正本仕様
- `docs/pdm/2026-09-06-scope-reduction-decision.md` — 要求確認前の過剰実装を避ける判断と経緯
- `docs/pdm/taguchi-system-roadmap.md` — 現行MVPから将来構想までのロードマップ
- `docs/pdm/mvp-implementation-plan.md` — 現行MVPの実装計画
- `docs/pdm/future-business-system-backlog.md` — 旧Proposalから継承した将来提案候補

## Historical proposal assets

`docs/proposal/` には、要求範囲を縮小する前に作成した業務システム構想・提案原稿を保存しています。

ここには、建材EC、一般注文・買掛注文、現場別発注、承認フロー、原価管理、管理ダッシュボード、仕入先ポータル、在庫・会計・BI連携等の検討内容が含まれます。

これらは破棄されたアイデアではなく、将来提案のための設計資産です。ただし、現時点の確定要求または実装予定を表すものではありません。実装判断では `docs/pdm/` のactive documentを優先してください。

旧Proposalの機能を実装対象へ戻す場合は、関係者への要求確認を行い、PDMのSpecification / Roadmap / Milestone / Plan等へ明示的に昇格させます。
