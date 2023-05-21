<?php

namespace App\Homework;

use Exception;
use League\CommonMark\CommonMarkConverter;

class ArticleContentProvider implements ArticleContentProviderInterface
{
    /** @var string конфигурируемая опция bold|cursive */
    private string $marker;

    /**
     * @var CommonMarkConverter
     */
    private CommonMarkConverter $commonMark;

    /**
     * @param string $mark
     * @param CommonMarkConverter $commonMark
     */
    public function __construct(string $mark, CommonMarkConverter $commonMark)
    {
        $this->marker = $mark;
        $this->commonMark = $commonMark;
    }

    /**
     * @param string $word
     * @return string
     * @throws Exception
     */
    public function markerWord(string $word): string
    {
        switch ($this->marker) {
            case 'bold':
                return "**$word**";
            case 'cursive':
                return "*$word*";
            default:
                throw new Exception('неизвестный параметр');
        }
    }

    /**
     * @param int $paragraphs
     * @param string|null $word
     * @param int $wordsCount
     * @return string
     */
    public function get(int $paragraphs, string $word = null, int $wordsCount = 0): string
    {
        $articles = $this->getParagraphs();
        $text = '';

        while ($paragraphs--) {
            $num = rand(0, count($articles) - 1);
            $text .= "<br><br>" . $articles[$num];
        }


        if (!is_null($word) && $wordsCount > 0) {
            $word = $this->markerWord($word);

            while ($wordsCount) {
                $randNum = rand(0, mb_strlen($text));

                if ($text[$randNum] === ' ') {
                    $endText = mb_strlen($text) - $randNum;

                    $text = mb_substr($text, 0, $randNum) . " $word " . mb_substr($text, $randNum, $endText);
                    $wordsCount--;
                }
            }
        }

        return $this->commonMark->convert($text);
    }

    /**
     * @return array
     */
    public function getParagraphs(): array
    {
        return [
"[My name is Aleksasendr](/).I am a university student. Every day I have three or four classes, so I do not usually have much time for meals. Cooking is not my hobby, I usually eat what my mother cooks for me or go to the student canteen. In the morning we gather together in our kitchen at 7 o'clock and have our breakfast. It is a family tradition. My mother lays the table. There are different kinds of sandwiches, sausages, bacon with eggs and jam. I often drink a cup of tea or coffee and eat a sandwich with butter and cheese.",

'`As there is a student canteen at the university`,I often go there for dinner after classes. There you may choose between different kinds of soup, meat and fish dishes and desserts. I often choose borsch for the first course and beefsteak for the second one. For dessert I often take stewed fruit or jelly. In our university canteen I usually have dinner with my friends. We may discuss our student life and make plans for the evening.',
 
'[I often come home at about seven](/). As I am often hungry after a long day. I do not have a snack in the evening. My supper is a full meal. My mother usually cooks mashed potatoes with meat or sausages, and salads, of course. After supper I do my home work, play computer games and watch TV. Before going to bed I sometimes eat some fruit or drink fruit juice.',

"`Thank you for your letter`! I will answer your questions about my family with pleasure. Today is Sunday, so we are all together. It is raining, that's why we are all sitting in the living room. My Mom is reading. She is a teacher of literature, so she reads a lot. She is a slim woman of about 40. Her pupils like her for she is an easy­ going and a kind person. Reading is her hobby. Besides, she is fond of cooking.",

'[He decided to become a doctor](/), because his father, my grandfather, was a doctor too. They look very much alike. All my grandparents are retired now. They all live in the village, where my parents come from. They are happy to see the entire family when we come to them. We have many relatives. My aunts, uncles, and cousins live in different parts of Ukraine. On holidays we often gather together and have a very good time!'
];
    }
}