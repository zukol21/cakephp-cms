<?php
namespace Cms\Test\TestCase\View;

use Cms\View\Shortcode;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Cms\Model\Table\ArticlesTable Test Case
 */
class ShortcodeTest extends TestCase
{
    public function testGetPlainShortcode()
    {
        $content = 'A plain [foo] shortcode.';
        $expected = [
            ['full' => '[foo]', 'name' => 'foo', 'params' => [], 'content' => '']
        ];

        $this->assertEquals($expected, Shortcode::get($content));
    }

    public function testGetPlainShortcodeWithClosingTag()
    {
        $content = 'A plain [foo][/foo] shortcode.';
        $expected = [
            ['full' => '[foo][/foo]', 'name' => 'foo', 'params' => [], 'content' => '']
        ];

        $this->assertEquals($expected, Shortcode::get($content));
    }

    public function testGetShortcodeWithParams()
    {
        $content = 'Shortcode [foo hello="world" world=\'hello\'] with parameters.';
        $expected = [
            [
                'full' => '[foo hello="world" world=\'hello\']',
                'name' => 'foo',
                'params' => ['hello' => 'world', 'world' => 'hello'],
                'content' => ''
            ]
        ];

        $this->assertEquals($expected, Shortcode::get($content));
    }

    public function testGetShortcodeWithParamsAndClosingTag()
    {
        $content = 'Shortcode [foo hello="world" world=\'hello\'][/foo] with parameters.';
        $expected = [
            [
                'full' => '[foo hello="world" world=\'hello\'][/foo]',
                'name' => 'foo',
                'params' => ['hello' => 'world', 'world' => 'hello'],
                'content' => ''
            ]
        ];

        $this->assertEquals($expected, Shortcode::get($content));
    }

    public function testGetWithEmptyContent()
    {
        $content = '';
        $expected = [];

        $this->assertEquals($expected, Shortcode::get($content));
    }

    /**
     * @dataProvider invalidContentProvider
     */
    public function testGetWithInvalidContent($content, $expected)
    {
        $this->assertEquals($expected, Shortcode::get($content));
    }

    public function invalidContentProvider()
    {
        return [
            [['foo'], []],
            [357, []],
            [true, []],
            [new stdClass, []],
        ];
    }

    public function testParseNonExistingShortcode()
    {
        $content = 'A non-parsable [foo] shortcode.';
        $shortcodes = Shortcode::get($content);
        $expected = '';

        foreach ($shortcodes as $shortcode) {
            $this->assertEquals($expected, Shortcode::parse($shortcode));
        }
    }

    public function testParseEmptyShortcode()
    {
        $shortcode = [];
        $expected = '';

        $this->assertEquals($expected, Shortcode::parse($shortcode));
    }

    public function testParseGalleryWithoutPath()
    {
        $content = 'A [gallery] shortcode.';
        $shortcodes = Shortcode::get($content);
        $expected = '<div class="alert alert-danger" role="alert">Gallery has no path</div>';

        foreach ($shortcodes as $shortcode) {
            $this->assertEquals($expected, Shortcode::parse($shortcode));
        }
    }

    public function testParseGalleryWithInvalidPath()
    {
        $content = 'A [gallery path="/some/random/path"] shortcode with invalid path.';
        $shortcodes = Shortcode::get($content);
        $expected = '<div class="alert alert-danger" role="alert">No images found in: some/random/path</div>';

        foreach ($shortcodes as $shortcode) {
            $this->assertEquals($expected, Shortcode::parse($shortcode));
        }
    }

    public function testParseGalleryWithoutImages()
    {
        // current dir as path
        $content = 'A [gallery path="js"] shortcode without images.';
        $shortcodes = Shortcode::get($content);
        $expected = '<div class="row"></div>';

        foreach ($shortcodes as $shortcode) {
            $this->assertEquals($expected, Shortcode::parse($shortcode));
        }
    }
}
