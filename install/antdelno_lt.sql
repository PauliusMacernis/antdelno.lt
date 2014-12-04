-- Generation Time: Dec 04, 2014 at 06:59 AM
-- Server version: 5.5.36-cll
-- PHP Version: 5.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `antdelno_lt`
--
CREATE DATABASE IF NOT EXISTS `antdelno_lt` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `antdelno_lt`;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `modified`, `order`) VALUES
('content_messages_post_form', NULL, '<br />\r\n                            <br /><br /><span class="footnote">Ši žinutė bus matoma visiems. Norėdami informuoti privačiai, <br />telefonu susisiekite su Juo (+000 000 00000) arba Ja (+000 000 00000). <br />Jeigu siunčiant daugiau nuotraukų siuntimas nutrūksta, siųskite mažesnėmis porcijomis arba susisiekite su mumis.</span>\r\n\r\n                            <br /><br />\r\n\r\n                            &nbsp;', '2014-12-04 05:35:42', 0),
('content_questions_answers', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam feugiat sollicitudin est eu maximus. Proin eget metus et lacus commodo maximus eget eget massa. Nullam lobortis ante dolor, a dictum dui commodo ut. Donec lorem erat, fermentum ut ante vel, pulvinar hendrerit velit. Nullam porta sed ipsum id maximus. Praesent at lacus imperdiet, ornare dui at, hendrerit nisl. Quisque et elit vitae est ullamcorper consectetur. Nullam in mollis metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla eget venenatis quam, finibus egestas orci. Curabitur suscipit malesuada finibus. Duis convallis elit quis metus tempus ultricies. Maecenas vel dui a nibh molestie scelerisque id eu lorem.</p><p>Donec lobortis volutpat justo, eget suscipit mi ullamcorper in. Phasellus elit quam, vulputate ut augue nec, pulvinar accumsan nulla. Donec quis tempus nulla. Sed sit amet feugiat mauris, et molestie nulla. Sed porttitor faucibus sem sed finibus. Pellentesque imperdiet lorem neque, sed bibendum nunc pellentesque ac. In hac habitasse platea dictumst. Ut mollis pharetra neque, at aliquam dui cursus sit amet. Donec nec suscipit quam. Quisque at iaculis diam. Nulla ut quam faucibus ligula aliquam aliquam fermentum at urna. Cras vestibulum dictum ultrices. Donec mollis blandit purus, in ultricies enim ultricies et. Sed blandit purus neque, in congue urna convallis vitae. Praesent non nunc malesuada, egestas erat a, fermentum augue.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nisl ipsum, facilisis id magna efficitur, suscipit faucibus felis. Aliquam erat volutpat. Morbi ultricies ante a velit tempus, vel ullamcorper sem bibendum. Etiam sit amet sodales tortor. Quisque convallis purus vitae ante congue, vitae ultrices nisl feugiat. Fusce egestas quam vel volutpat laoreet. Etiam bibendum lobortis finibus. Pellentesque sagittis consectetur lorem auctor consectetur. Suspendisse justo massa, varius non accumsan ut, sagittis in metus. Nam ut iaculis felis. In cursus, libero semper venenatis tincidunt, tortor massa imperdiet ligula, et volutpat enim neque fermentum nisi. Nullam sagittis aliquam velit, maximus mollis mauris sagittis eu.</p><p>Nullam iaculis gravida mi, eget porttitor eros suscipit eu. Curabitur vitae odio mauris. Phasellus at orci vel purus vehicula suscipit at varius diam. Ut non lectus at mi consectetur luctus. Phasellus tristique arcu eu justo volutpat, vitae efficitur felis tincidunt. Sed luctus est justo, vel condimentum elit semper lobortis. Quisque ultrices neque dignissim dolor aliquam rutrum. Vivamus id dui ut ante mattis accumsan. Proin quis metus quis risus sagittis porta. Sed at imperdiet libero, at ornare dolor. In at faucibus risus. Proin aliquam massa sed pellentesque suscipit. Suspendisse ut congue lorem, ut euismod enim. Morbi maximus, mauris non ultricies malesuada, magna augue imperdiet odio, quis scelerisque mauris neque sed augue. Proin diam ligula, imperdiet in consequat id, hendrerit in ante. Mauris risus tortor, facilisis in condimentum id, sagittis ac tellus.</p><p>Maecenas libero nulla, mollis commodo consequat a, sodales non libero. Aliquam eu leo at nunc rhoncus interdum. Donec lectus tortor, consequat placerat mauris in, lobortis porttitor felis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla vitae finibus mauris. In pellentesque interdum dignissim. Cras pharetra augue tortor, a sodales eros vulputate quis.</p>', '2014-12-04 05:15:43', 0),
('content_thanks', NULL, '<p>Aenean sed fermentum risus. Ut sed feugiat enim, id feugiat risus. Proin viverra, turpis at mollis cursus, nibh justo lacinia nulla, id porttitor ex erat nec sem. Nunc sed suscipit magna. Vestibulum ligula libero, egestas sit amet eros sed, convallis ultricies elit. Phasellus id vehicula odio. Vestibulum imperdiet justo nisi, sed eleifend enim laoreet eget. Maecenas quis ante erat. Vivamus tincidunt vitae ligula sit amet tincidunt. Vestibulum convallis metus tempus massa luctus, id lacinia eros mollis. Curabitur hendrerit quam eu vestibulum congue. Etiam luctus egestas diam, quis gravida metus vulputate at. Nam efficitur, erat nec rhoncus euismod, ex dolor tincidunt velit, in tempus erat orci a dui. In augue nulla, imperdiet id volutpat at, tempus at turpis.</p><p>Nunc posuere nisl vel arcu laoreet tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Cras sed tortor finibus ipsum dignissim malesuada at sed massa. Suspendisse bibendum finibus sem ut faucibus. Sed non odio nunc. Aenean sit amet laoreet est, sed imperdiet justo. Mauris tempor vitae erat nec vestibulum. Maecenas porta quis purus efficitur rutrum. Integer vestibulum elementum urna, quis lobortis odio bibendum sed.</p>', '2014-12-04 05:28:49', 0),
('content_video', NULL, '<h1>Proin vitae dapibus tortor...</h1> \r\n\r\n													<video id="rp" class="video-js vjs-default-skin" controls\r\n													 preload="auto" width="800" height="600" poster="/images/kvietimas.jpg"\r\n													 data-setup="{}">\r\n													 <source src="/videos/kvietimas.flv" type=''video/x-flv''>\r\n													 <source src="/videos/kvietimas.mp4" type=''video/mp4''>\r\n													 <source src="/videos/kvietimas.webm" type=''video/webm''>\r\n													 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>\r\n													</video>\r\n\r\n                            <!-- you *must* offer a download link as they may be able to play the file locally. customise this bit all you want -->\r\n                            <p id="intro_not_available">Norėdami atsisiųsti šį vaizdo įrašą - \r\n                                <a href="/videos/kvietimas.mp4" download="kvietimas_-_2014_08_02.mp4">spauskite čia</a>.\r\n                            </p>', '2014-12-04 05:21:40', 0),
('login', NULL, '<p>Norėdami matyti turinį, įveskite <abbr title="Jeigu nežinote slaptažodžio, susisiektite su Juo (+000 000 00000) arba Ja (+000 000 00000)">slaptažodį</abbr> ir paspauskite mygtuką &bdquo;Įeiti&ldquo;.</p>', '2014-12-04 02:21:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments_on_intro`
--

CREATE TABLE IF NOT EXISTS `comments_on_intro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` text COLLATE utf8_unicode_ci,
  `message` mediumtext COLLATE utf8_unicode_ci,
  `message_is_old` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=47 ;

--
-- Dumping data for table `comments_on_intro`
--

INSERT INTO `comments_on_intro` (`id`, `nickname`, `message`, `message_is_old`, `updated`) VALUES
(1, 'Maecenas ut Venenatis ex', 'Sed quis porttitor tellus.\r\n\r\nMauris lectus nunc, tristique non mauris vitae, luctus pellentesque est.\r\nVivamus sodales nec lectus et efficitur. Vivamus scelerisque, lectus ut commodo venenatis, sem quam ornare nunc, eu aliquet eros nisl id mi. Etiam aliquet tortor sed odio iaculis, vel varius massa volutpat. In eu maximus magna. Mauris nec orci urna.\r\nSuspendisse aliquet orci eget nunc elementum elementum. Cras dapibus, nisl nec consectetur porttitor, nisl sem interdum dui, sed ornare urna turpis ut lorem. ', 1, '2014-05-20 00:01:36'),
(2, 'Integer Purus libero', 'Donec blandit dolor ac sem posuere tristique. Cras venenatis libero id tellus vulputate porta. Pellentesque et nunc nec ligula varius porttitor nec in tortor. Quisque aliquet, eros sit amet gravida gravida, velit nunc vehicula ligula, ac imperdiet neque quam non elit. Sed eget auctor nisi, sit amet dignissim ligula. In mi purus, dignissim eu pharetra et, scelerisque a metus. Pellentesque ac convallis erat. In egestas varius nisl at venenatis.', 1, '2014-05-20 20:52:04'),
(3, 'Nunc Ante', 'Nunc enim massa, maximus ac lacus vel, convallis imperdiet nibh.', 1, '2014-08-01 12:28:57'),
(4, 'Fusce Bibendum', 'Cras vitae blandit sem, at vulputate enim.', 0, '2014-08-04 12:28:57'),
(5, 'Maecenas Porttitor', 'Integer sit amet risus in tellus porttitor molestie. Etiam facilisis enim et lobortis tempor. Quisque dignissim, diam quis fringilla laoreet, tellus diam fringilla mi, id malesuada dolor velit ut magna.', 0, '2014-08-04 12:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `passwords_public`
--

CREATE TABLE IF NOT EXISTS `passwords_public` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `passwords_public`
--

INSERT INTO `passwords_public` (`id`, `password`) VALUES
(1, 'ourspassword');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
