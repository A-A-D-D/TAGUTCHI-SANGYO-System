---
pdm_version: "0.1"
id: taguchi-ui-css-architecture-decision
name: UI/CSSアーキテクチャ決定
slug: ui-css-architecture
type: architecture.decision
status: active
created_at: 2026-09-06
updated_at: 2026-09-06
owners:
  - a-a-d-d
relations:
  - type: informs
    target: taguchi-mvp-implementation-plan
  - type: informs
    target: taguchi-system-roadmap
---

# UI/CSSアーキテクチャ決定

## Context

既存テーマには独自CSS、外部CSS、WooCommerce向けテンプレートが混在しています。MVP提示に向けてUI品質を短時間で引き上げる必要がありますが、既存CSSへ局所修正を積み重ねると保守性と一貫性を損ないます。

`Period-Inc/Codes` はCSSを再利用・置換・拡張可能な資産として扱い、token / base / layout / component / utility / page-specific等の責務を分離し、utility frameworkを実装手段として利用可能としています。CodesはTailwind自体を必須化していません。

## Decision

本プロジェクトではTailwind CSSを採用します。ただしTailwind utility classをテンプレートの設計語彙として直接大量に散在させる方式は採用しません。

プロジェクト側に以下の抽象化境界を置きます。

1. **Token layer** — 色、余白、文字、角丸、影、状態等の意味を管理する。
2. **Base layer** — HTML要素とサイト全体の基礎表現を管理する。
3. **Layout layer** — page/container/stack/grid等、配置責務を管理する。
4. **Component layer** — form field、button、notice、card、order summary等、業務UI単位を管理する。
5. **Utility layer** — Tailwindのutilityを限定的・予測可能に利用する。
6. **Page-specific layer** — 本当にその画面だけの差分に限定する。

Tailwindは上記レイヤーを実現するための下位実装として使用します。再利用されるUIはsemantic class/componentへ集約し、必要に応じてTailwindの `@apply`、theme/token設定、component抽象等へ射影します。

既存CSSは一括削除せず、MVP対象画面から段階的に移行します。

## Consequences

### 利点

- MVPのUI品質を短時間で揃えやすい。
- Tailwindの生産性を利用しつつ、HTMLがutilityの羅列に固定されることを防げる。
- 将来Tailwindを交換・更新する場合も、project semantic layerを境界にできる。
- CodesのCSS資産化方針と整合する。
- 既存テーマを全面改修せず段階移行できる。

### 制約

- その場の見た目だけを理由にutility classを追加し続けない。
- semantic classは見た目ではなく役割・責務で命名する。
- 抽象化が未確定な一回限りの表現を過剰に共通化しない。
- WooCommerceや第三者プラグインのmarkup制約に対するoverrideは、外部制約であることが分かる場所に隔離する。
- `!important` は第三者CSS等の明確な理由がある場合に限定する。
