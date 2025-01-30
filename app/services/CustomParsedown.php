<?php 

namespace App\Services;

use Parsedown;

class CustomParsedown extends Parsedown {

    public function __construct()
    {
        // Add the custom type
        $this->InlineTypes['{'] = ['CustomButton'];
        $this->InlineTypes['<'] = ['CustomSpan'];

        $this->inlineMarkerList .= '{<';
    }

    // For Custom Button
    public function inlineCustomButton($Excerpt)
    {
        // Change the number if you have more than one syntax
        if (substr($Excerpt['text'], 0, 1) === '{') { // Starting Syntax
            $endLabel = strpos($Excerpt['text'], '}');
            $startLink = strpos($Excerpt['text'], '[', $endLabel);
            $endLink = strpos($Excerpt['text'], ']', $startLink); // Starting Syntax

            if ($endLabel !== false && $startLink !== false && $endLink !== false) {
                // Extract the button label and link
                $label = substr($Excerpt['text'], 1, $endLabel - 1);
                $link = substr($Excerpt['text'], $startLink + 1, $endLink - $startLink - 1);

                return [
                    'extent' => $endLink + 1,
                    'element' => [
                        'name' => 'a',
                        'text' => $label,
                        'attributes' => [
                            'href' => $link,
                            'class' => 'custom-button',
                            'target' => '__blank',
                        ],
                    ],
                ];
            }
        }
        return null; // No valid match
    }


    // For Custom Span
    public function inlineCustomSpan($Excerpt)
    {
        // Change the number if you have more than one syntax
        if (substr($Excerpt['text'], 0, 2) === '<-') { // Starting Syntax
            $endLabel = strpos($Excerpt['text'], '->'); // Closing Syntax

            if ($endLabel !== false) {
                $label = substr($Excerpt['text'], 2, $endLabel - 2);

                return [
                    'extent' => $endLabel + 2,
                    'element' => [
                        'name' => 'span',
                        'text' => $label,
                        'attributes' => [
                            'class' => 'custom-span',
                        ],
                    ],
                ];
            }
        }
        return null; // No valid match
    }
}
