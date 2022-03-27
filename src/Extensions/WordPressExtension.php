<?php

namespace Themosis\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class WordPressExtension extends AbstractExtension
{
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array($name, $arguments);
    }

    public function getGlobals(): array
    {
        /**
         * The "fn" global allows you to call
         * any core or WordPress functions using
         * this syntax: fn.ucfirst('themosis')
         */
        return [
            'fn' => $this
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('body_class', function (string $class = '') {
                return body_class($class);
            }),
            new TwigFunction('post_class', function (string $class = '', ?int $post_id = null) {
                return post_class($class, $post_id);
            }),
            new TwigFunction('wp_head', 'wp_head'),
            new TwigFunction('wp_footer', 'wp_footer'),

            /**
             * Helper functions
             */
            new TwigFunction('fn', function (string $name) {
                $args = func_get_args();

                /**
                 * By default, the function signature should be the first argument.
                 * Let's remove it from the list of arguments.
                 */
                array_shift($args);

                return call_user_func_array(trim($name), $args);
            }),
            new TwigFunction('meta', function (int $object_id, string $meta_key, bool $single = false, string $meta_type = 'post') {
                return meta($object_id, $meta_key, $single, $meta_type);
            }),

            /**
             * Translations functions
             */
            new TwigFunction('__', function (string $text, string $domain = 'default') {
                return __($text, $domain);
            }),
            new TwigFunction('_e', function (string $text, string $domain = 'default') {
                return _e($text, $domain);
            }),
            new TwigFunction('_ex', function (string $text, string $context, string $domain = 'default') {
                return _ex($text, $context, $domain);
            }),
            new TwigFunction('_n', function (string $singular, string $plural, int $number, string $domain = 'default') {
                return _n($singular, $plural, $number, $domain);
            }),
            new TwigFunction('_n_noop', function (string $singular, string $plural, string $domain = 'default') {
                return _n_noop($singular, $plural, $domain);
            }),
            new TwigFunction('_nx', function (string $singular, string $plural, int $number, string $context, string $domain = 'default') {
                return _nx($singular, $plural, $number, $context, $domain);
            }),
            new TwigFunction('_nx_noop', function (string $singular, string $plural, string $context, string $domain = 'default') {
                return _nx_noop($singular, $plural, $context, $domain);
            }),
            new TwigFunction('_x', function (string $text, string $context, string $domain = 'default') {
                return _x($text, $context, $domain);
            }),
            new TwigFunction('translate', function (string $text, string $domain = 'default') {
                return translate($text, $domain);
            }),
            new TwigFunction('translate_nooped_plural', function (string $plural, int $count, string $domain = 'default') {
                return translate_nooped_plural($plural, $count, $domain);
            })
        ];
    }

    public function getFilters(): array
    {
        return [
            /**
             * Formatting filters.
             */
            new TwigFilter('wpantispam', function (string $email, int $encoding = 0) {
                return antispambot($email, $encoding);
            }),
            new TwigFilter('wpautop', function (string $text, bool $br = true) {
                return wpautop($text, $br);
            }),
            new TwigFilter('wpnofollow', function (string $text) {
                return wp_rel_nofollow($text);
            }),
            new TwigFilter('wptrimexcerpt', function (string $text) {
                return wp_trim_excerpt($text);
            }),
            new TwigFilter('wptrimwords', function (string $text, int $num_words = 55, ?string $more = null) {
                return wp_trim_words($text, $num_words, $more);
            }),
            new TwigFilter('zeroise', function (string $number, int $treshold = 4) {
                return zeroise($number, $treshold);
            })
        ];
    }
}
