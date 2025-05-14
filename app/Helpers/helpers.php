<?php

use Illuminate\Support\HtmlString;

if (!function_exists('buildTree')) {
    function buildTree($categories): HtmlString
    {
        $html = '<ol class="dd-list">';

        foreach ($categories as $category) {
            $html .= '<li class="dd-item" data-id="' . $category->id . '">';
            $html .= '<div class="dd-handle">' . htmlspecialchars($category->name) . '</div>';

            $html .= '<div style="margin-top: 5px;">';
            $html .= '<a href="' . route('categories.edit', $category) . '">✏️ Редактировать</a> | ';
            $html .= '<form method="POST" action="' . route('categories.destroy', $category) . '" style="display:inline">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" onclick="return confirm(\'Удалить?\')">🗑️ Удалить</button></form>';
            $html .= '</div>';

            if ($category->children && $category->children->count()) {
                $html .= buildTree($category->children);
            }

            $html .= '</li>';
        }

        $html .= '</ol>';

        return new HtmlString($html);
    }
}

