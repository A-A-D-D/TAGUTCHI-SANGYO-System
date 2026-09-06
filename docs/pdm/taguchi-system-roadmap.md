---
pdm_version: "0.1"
id: taguchi-system-roadmap
name: 田口産業システム ロードマップ
slug: taguchi-system
type: planning.roadmap
status: active
created_at: 2026-09-06
updated_at: 2026-09-06
owners:
  - a-a-d-d
relations:
  - type: informed_by
    target: taguchi-scope-reduction-decision
  - type: related_to
    target: taguchi-order-digitization-spec
  - type: related_to
    target: taguchi-future-business-system-backlog
  - type: related_to
    target: taguchi-ui-css-architecture-decision
---

# 田口産業システム ロードマップ

## Direction

最優先は、2026-09-07〜2026-09-13の週に、数時間の集中作業で提示可能なMVPへ到達することです。

MVPは現行正本仕様どおり「現場から本社への発注受付のオンライン化」に限定します。旧Proposalに含まれるEC、会員、注文管理、承認、原価管理等は将来提案資産として保持し、MVPへ混入させません。

実装マナーは `Period-Inc/Codes` を正とします。既存実装は必要以上に全面改修せず、MVPに必要な経路とUIから段階的に整えます。

## Horizons

### Horizon 0 — 現在地確認とMVP境界固定

状態: 実施中

確認済み:

- WordPressカスタムテーマ `taguchi_system` が存在する。
- WooCommerce向けテンプレート、カート、チェックアウト画面骨格が存在する。
- `functions.php` に相応量の既存ロジックがある。
- 現行MVPの正本はECではなく「Webフォーム → メール + PDF」である。
- Repository上では、現行MVPの一連動作が成立済みであることを示す実装・検証証拠をまだ確認できていない。
- Tailwind CSSは現時点で導入確認できていない。

この段階では、既存WooCommerce実装を完成させることを目標にしません。

### Horizon 1 — 提示用MVP完成

目標週: 2026-09-07〜2026-09-13

必須:

- 発注入力画面
- 必須項目の入力検証
- 本社向けメール送信
- 同一内容の発注書PDF生成
- メールとPDFの対応関係が追跡可能
- 代表ケースで一連動作を確認
- 提示時に違和感のないUI

UIについては、既存CSSへの場当たり的な追記ではなく、意味・責務を持つ抽象化レイヤーを経由してTailwind CSSを利用します。

MVP提示に不要な旧EC機能の完成、決済、承認、原価管理等は行いません。

### Horizon 2 — 受注側オペレーション改善

MVP提示・確認後に判断します。

候補:

- PDFの受注用PCへの自動保存
- PDF自動印刷
- 受付履歴
- 再送・再印刷
- 処理状況の簡易管理
- 訂正・取消運用

### Horizon 3 — 将来提案

旧Proposalを再利用し、要求確認が得られたものだけを提案・Planへ昇格します。

候補:

- 一般注文・買掛注文
- 現場別発注管理
- 承認フロー
- 発注・注文履歴管理
- 現場別原価集計
- 権限管理
- 価格履歴管理
- 管理ダッシュボード
- CSV等のデータ出力

### Horizon 4 — サプライチェーン連携

- 発注先・仕入先ポータル
- 納期回答
- 出荷登録
- 在庫連携
- 会計連携
- BI分析
- FAX API等の外部連携

## Milestones

1. **M0: 現在地確定** — 現行実装と現行MVP仕様の差分を把握し、実装対象外を明示する。
2. **M1: 提示用オンライン発注MVP** — フォームから送信し、本社でメールと対応PDFを受領でき、UIも提示可能な品質である。
3. **M2: 既存業務への安定接続** — 保存・印刷を含む受注側運用が安定する。
4. **M3: 次段階の要求確認** — 将来提案項目の必要性と優先度を関係者と確認する。
5. **M4以降: 承認済み機能の段階導入** — 要求確認済み項目だけをPlanへ昇格する。

## Dependencies

- M1は発注フォーム項目、通知先、PDF様式の最終確認に依存する。
- UI刷新は既存テーマとの回帰を避けるため、MVP対象画面から段階導入する。
- Tailwindは直接HTMLへ無秩序にutility classを散布する目的では使用しない。プロジェクト側のsemantic/component層を境界とする。
- Horizon 2以降はMVPの実利用・提示結果に依存する。
- Horizon 3以降は元請けを含む関係者の要求確認と合意に依存する。
