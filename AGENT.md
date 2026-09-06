## 共通ポリシー

本プロジェクトは、共通開発ポリシー・実装マナーとして `Period-Inc/Codes` をauthorityとする。

- `Period-Inc/Codes/AGENT.md`
- `Period-Inc/Codes/docs/development-policy.md`
- 必要に応じて `Period-Inc/Codes/principles/`

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

### MVP Priority

2026-09-07〜2026-09-13の優先目標は、数時間の集中作業で提示可能な「Webフォーム → 本社メール + PDF発注書」のMVPを完成させること。

旧Proposal由来のEC、決済、注文管理、承認、原価管理等をMVPへ混入させない。

### UI / CSS

UI実装は `docs/pdm/2026-09-06-ui-css-architecture-decision.md` に従う。

Tailwind CSSは下位実装として利用し、semantic / layout / component等のプロジェクト側抽象化レイヤーを設ける。

既存CSSを全面置換せず、MVP対象画面から段階移行する。utility classの場当たり的な散在を避ける。
