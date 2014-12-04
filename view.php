<?php

class MainView {

    protected function getLayout($file_name = 'login.html') {

        return file_get_contents(_ROOT_DIR . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $file_name);
    }

    protected function getPageTitle() {
        return 'PR';
    }

    protected function getCss() {

        $result = <<<CSS
<link rel="stylesheet" href="/css/main.css" />
<link rel="stylesheet" href="/css/colorbox.css" />
CSS;

        return $result;
    }

    protected function getJavaScript() {

        $return = <<<JS
<script src="/js/jquery-2.1.1.min.js"></script>
<script src="/js/colorbox/jquery.colorbox-min.js"></script>
<script src="/js/main.js"></script>
JS;

        return $return;
    }

    protected function getVideoPlayer() {

        $return = <<<VIDEO_PLAYER
<link href="/video_player/video-js.min.css" rel="stylesheet">
<script src="/video_player/video.js"></script>
VIDEO_PLAYER;

        return $return;
    }

    public function login($content_text = '') {

        $layout = $this->getLayout('login.html');

        $result = str_replace('{PAGE_TITLE}', $this->getPageTitle(), $layout);
        $result = str_replace('{PAGE_CSS}', $this->getCss(), $result);
        $result = str_replace('{PAGE_JAVASCRIPT}', $this->getJavaScript(), $result);

        $result = str_replace('{CONTENT}', $content_text, $result);

        return $result;
    }

    private function getMessagesList(MainModel $Model, $messages = array(), $messages_amount = 0) {

        $result = '';

        if (isset($messages) && is_array($messages) && !empty($messages)) {

            $result .= '<ul id="comments">';

            foreach ($messages as $message) {

                // images
                $files_thumbnail = $Model->getMessageFiles($message->id, 'thumbnail');
                $files_lightbox = $Model->getMessageFiles($message->id, 'lightbox');
                $files_original = $Model->getMessageFiles($message->id);

                $result .= '<li class="' . ($message->message_is_old ? 'old_message' : 'new_message') . '">
                                <span class="timestamp">' . htmlspecialchars($message->updated, ENT_QUOTES, 'UTF-8') . '</span>
                                <br /><span class="nickname">' . htmlspecialchars($message->nickname, ENT_QUOTES, 'UTF-8') . '</span>:
                                <div>' . nl2br(htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8')) . '</div>
                                <div class="images">';

                foreach ($files_original as $key => $file_url) {

                    if (!isset($files_thumbnail[$key]) && !isset($files_lightbox[$key])) {
                        $result .= '<a href="' . $files_original[$key] . '" title="' . $files_original[$key] . '" download="' . pathinfo($files_original[$key], PATHINFO_BASENAME) . '"><img class="uploaded_image" src="/images/download.png" /></a>';
                        continue;
                    }

                    if (!isset($files_thumbnail[$key])) {
                        $result .= '<span style="color: red; font-size:14px;" title="Klaida: Nėra thumbnail paveikslėlio versijos, todėl paveikslėlis ' . htmlspecialchars(urldecode($key)) . ' nerodomas">T!</span>';
                        //continue;
                    }

                    if (!isset($files_lightbox[$key])) {
                        $result .= '<span style="color: red; font-size:14px;" title="Klaida: Nėra lightbox paveikslėlio versijos, todėl paveikslėlis ' . htmlspecialchars(urldecode($key)) . ' nerodomas">L!</span><a href="' . $files_original[$key] . '" title="' . $files_original[$key] . '" download="' . pathinfo($files_original[$key], PATHINFO_BASENAME) . '"><img class="uploaded_image" src="/images/download.png" /></a>';
                        continue;
                    }

                    //if(!isset($files_original[$key])) {
                    //    $result .= '<span style="color: red; font-size:14px;" title="Klaida: Nėra originalios paveikslėlio versijos, todėl paveikslėlis ' . htmlspecialchars(urldecode($key)) . ' nerodomas">O!</span>';
                    //    continue;
                    //} 

                    $result .= '<a class="uploaded_image" href="' . $files_lightbox[$key] . '" title="' . $files_original[$key] . '."><img class="uploaded_image" src="' . $files_thumbnail[$key] . '" /></a><a class="download_button" download="' . pathinfo($files_original[$key], PATHINFO_BASENAME) . '" href="' . $files_original[$key] . '"><img class="download_button" src="/images/download.png" /></a>';
                }


                $result .= '</div>
                            </li>';
            }

            $result .= '</ul>';

            $result .= '<p style="text-align:left;padding-left:40px;padding-top:10px;font-size:12px;"><input type="checkbox" name="show_old_messages" id="show_old_messages" onchange="showOrHideOldMessages(); return false;"><label for="show_old_messages">Rodyti žinutes, išsiųstas iki šventės</label></p>';
        }

        return $result;
    }

    private function getMessagesPostForm(MainModel $Model, $messages = array(), $messages_amount = 0) {

        $result = '<div id="info_message" style="display:none;"></div>
                    <form action="/" method="post" enctype="multipart/form-data" id="form_comment">
                        <fieldset class="comment">
                            <h2>Rašykite ir išsiųskitę žinutę</h2>
                            <legend>...</legend>

                            <label for="nickname">Prisistatykite:</label>
                            <br /><input type="text" name="nickname" id="nickname" required placeholder="Įrašykite čia savo Vardą bei Pavardę" value="" />

                            <br /><br />

                            <label for="message">Žinutė:</label>
                            <br /><textarea rows="4" id="message" name="message" cols="50" required placeholder="Įrašykite čia savo žinutę."></textarea>
                            <br />Kartu su žinute galite siųsti nuotraukas arba vaizdo medžiagą:
                            <br /><input type="file" name="attachments[]" title="Pridėti bylas (pvz. nuotraukas, vaizdo medžiagą)" multiple>';

        $result .= $Model->getContent('content_messages_post_form');

        $result .= '        <input type="submit" value="Išsiųsti" onclick="submitComment();" />

                        </fieldset>
                        <input type="hidden" name="action" value="post_comment" />
                    </form>';

        return $result;
    }

    public function index(MainModel $Model, $messages = array(), $messages_amount = 0) {

        $layout = $this->getLayout('index.html');

        // <HEAD>
        $result = str_replace('{PAGE_TITLE}', $this->getPageTitle(), $layout);
        $result = str_replace('{PAGE_CSS}', $this->getCss(), $result);
        $result = str_replace('{PAGE_JAVASCRIPT}', (
                $this->getVideoPlayer()
                . $this->getJavaScript()
                ), $result);

        // Variables
        $result = str_replace('{MESSAGES_AMOUNT}', $messages_amount, $result);

        // Content
        $result = str_replace('{CONTENT_QUESTIONS_ANSWERS}', $Model->getContent('content_questions_answers'), $result);
        $result = str_replace('{CONTENT_VIDEO}', $Model->getContent('content_video'), $result);
        $result = str_replace('{CONTENT_MESSAGES_LIST}', $this->getMessagesList($Model, $messages, $messages_amount), $result);
        $result = str_replace('{CONTENT_MESSAGES_POST_FORM}', $this->getMessagesPostForm($Model, $messages, $messages_amount), $result);
        $result = str_replace('{CONTENT_THANKS}', $Model->getContent('content_thanks'), $result);

        return $result;
    }

}
