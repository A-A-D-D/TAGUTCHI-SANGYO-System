## 共通ポリシー

本プロジェクトは、共通開発ポリシーとして以下を参照する。

../_dev_global/AGENT.md

この AGENT.md にはプロジェクト固有事項のみを記載する。

---

## プロジェクト固有事項

### Documentation

本プロジェクトの現行要求・判断・計画は `docs/pdm/` の PDM document をauthorityとする。

このプロジェクトでは日本語をcanonical documentation languageとして扱う。

`docs/proposal/` は要求範囲縮小前に作成した旧Proposalの原稿・設計資産であり、将来提案のために保存する。ただし、activeな現行仕様または実装予定として解釈してはならない。

旧Proposalに含まれる機能を実装対象へ戻す場合は、関係者への要求確認を根拠として、PDMのSpecification / Roadmap / Milestone / Plan / Backlog item等へ明示的に昇格させること。

現行MVPの正本仕様は `docs/pdm/order-digitization-spec.md` とする。

実装変更によって要求・責任境界・MVP範囲が変わる場合は、コードだけを変更せず関連PDM documentも同じ変更単位で更新する。
