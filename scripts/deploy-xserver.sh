#!/bin/bash
# deploy-xserver.sh
# XServer 上でのデプロイスクリプト（deploy-kit ラッパー）
#
# 使い方:
#   bash deploy-xserver.sh          # ドライラン（差分確認のみ）
#   bash deploy-xserver.sh --apply  # 実反映
#   bash deploy-xserver.sh --init   # 初回クローン
#
# 前提:
#   - サーバー上で実行する（ローカルから SSH 越しに実行しない）
#   - deploy-kit（github-app-clone / github-app-pull / wp-theme-deploy）が利用可能なこと
#   - Composer が利用可能なこと（MVP PDF生成の mPDF 依存を解決するため）
#   - 初回は --init オプションで clone する

set -euo pipefail

# ── 設定 ────────────────────────────────────────────────────────────────────
REPO_SLUG="A-A-D-D/TAGUTCHI-SANGYO-System"
# 既存サーバー配置との互換性のため repo directory は当面据え置く。
REPO_DIR="$HOME/repos/taguchi-sangyo"
SITE_ROOT="$HOME/design-arts.jp/public_html/dev.taguchi-s.design-arts.jp"

THEME_REL="wp-content/themes/taguchi_system"
THEME_DEST="$SITE_ROOT/$THEME_REL/"

MU_LOADER_REL="wp-content/mu-plugins/taguchi-order-mvp.php"
MU_PACKAGE_REL="wp-content/mu-plugins/taguchi-order-mvp"
MU_DEST="$SITE_ROOT/wp-content/mu-plugins"
# ── /設定 ───────────────────────────────────────────────────────────────────

# ── オプション解析 ──────────────────────────────────────────────────────────
APPLY=false
INIT=false
for arg in "$@"; do
  case "$arg" in
    --apply) APPLY=true ;;
    --init)  INIT=true ;;
    --help|-h)
      echo "使い方: $0 [--apply | --init]"
      echo "  オプションなし : ドライラン（変更内容の確認のみ）"
      echo "  --apply        : 実反映"
      echo "  --init         : 初回クローン（github-app-clone を実行）"
      exit 0
      ;;
    *) echo "不明なオプション: $arg" >&2; exit 1 ;;
  esac
done
# ── /オプション解析 ─────────────────────────────────────────────────────────

# ── 初回クローン ────────────────────────────────────────────────────────────
if $INIT; then
  echo "=== 初回クローン ==="
  github-app-clone "$REPO_SLUG" "$REPO_DIR"
  echo "クローン完了: $REPO_DIR"
  exit 0
fi
# ── /初回クローン ───────────────────────────────────────────────────────────

# ── 事前チェック ────────────────────────────────────────────────────────────
if [[ ! -d "$REPO_DIR/.git" ]]; then
  echo "[ERROR] リポジトリが見つかりません: $REPO_DIR" >&2
  echo "        初回セットアップ: bash $0 --init" >&2
  exit 1
fi

if [[ ! -f "$REPO_DIR/$MU_PACKAGE_REL/composer.json" ]]; then
  echo "[ERROR] MVP MU plugin の composer.json が見つかりません" >&2
  exit 1
fi

if $APPLY && [[ ! -f "$REPO_DIR/$MU_PACKAGE_REL/composer.lock" ]]; then
  echo "[ERROR] composer.lock がありません。依存を確定してからデプロイしてください。" >&2
  echo "        cd $REPO_DIR/$MU_PACKAGE_REL && composer update" >&2
  exit 1
fi
# ── /事前チェック ────────────────────────────────────────────────────────────

# ── リポジトリ更新 ──────────────────────────────────────────────────────────
echo "=== github-app-pull ==="
github-app-pull "$REPO_DIR"
echo ""
# ── /リポジトリ更新 ─────────────────────────────────────────────────────────

# ── Theme ───────────────────────────────────────────────────────────────────
if $APPLY; then
  echo "=== wp-theme-deploy [APPLY] ==="
  wp-theme-deploy \
    --repo  "$REPO_DIR" \
    --theme "$THEME_REL" \
    --dest  "$THEME_DEST"
else
  echo "=== wp-theme-deploy [DRY-RUN] === （実際のファイルは更新されません）"
  wp-theme-deploy \
    --repo  "$REPO_DIR" \
    --theme "$THEME_REL" \
    --dest  "$THEME_DEST" \
    --dry-run
fi
echo ""
# ── /Theme ──────────────────────────────────────────────────────────────────

# ── MVP MU plugin ───────────────────────────────────────────────────────────
echo "=== taguchi-order-mvp ==="

if $APPLY; then
  if ! command -v composer >/dev/null 2>&1; then
    echo "[ERROR] composer が見つかりません" >&2
    exit 1
  fi

  composer install \
    --working-dir="$REPO_DIR/$MU_PACKAGE_REL" \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader

  mkdir -p "$MU_DEST/taguchi-order-mvp"

  install -m 0644 \
    "$REPO_DIR/$MU_LOADER_REL" \
    "$MU_DEST/taguchi-order-mvp.php"

  rsync -rc --delete \
    "$REPO_DIR/$MU_PACKAGE_REL/" \
    "$MU_DEST/taguchi-order-mvp/"
else
  echo "[DRY-RUN] loader: $REPO_DIR/$MU_LOADER_REL -> $MU_DEST/taguchi-order-mvp.php"
  echo "[DRY-RUN] package: $REPO_DIR/$MU_PACKAGE_REL/ -> $MU_DEST/taguchi-order-mvp/"

  if [[ -d "$MU_DEST/taguchi-order-mvp" ]]; then
    rsync -rcni --delete \
      --exclude vendor/ \
      "$REPO_DIR/$MU_PACKAGE_REL/" \
      "$MU_DEST/taguchi-order-mvp/" || true
  fi
fi

echo ""
# ── /MVP MU plugin ──────────────────────────────────────────────────────────

if $APPLY; then
  echo "=== デプロイ完了 ==="
else
  echo "=== ドライラン完了 ==="
  echo "実反映するには: bash $0 --apply"
fi
