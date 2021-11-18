-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2021 at 09:06 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebook_app_buyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_active_log`
--

CREATE TABLE `tbl_active_log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'viaviwebtech@gmail.com', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_author`
--

CREATE TABLE `tbl_author` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_city_name` varchar(255) NOT NULL,
  `author_description` text NOT NULL,
  `author_image` varchar(255) NOT NULL,
  `author_youtube` varchar(500) NOT NULL,
  `author_instagram` varchar(500) NOT NULL,
  `author_facebook` varchar(500) NOT NULL,
  `author_website` varchar(500) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_author`
--

INSERT INTO `tbl_author` (`author_id`, `author_name`, `author_city_name`, `author_description`, `author_image`, `author_youtube`, `author_instagram`, `author_facebook`, `author_website`, `status`) VALUES
(1, 'A. P. J. Abdul Kalam', 'Rameswaram,India', 'Avul Pakir Jainulabdeen Abdul Kalam was an Indian scientist who served as the 11th President of India from 2002 to 2007. He was born and raised in Rameswaram, Tamil Nadu and studied physics and aerospace engineering.\r\n', '49757_apj.jpeg', 'https://www.youtube.com/viaviwebtech/', 'https://www.instagram.com/viaviwebtech/', 'https://www.facebook.com/viaviweb', 'https://codecanyon.net/user/viaviwebtech/portfolio', 1),
(2, 'Jawaharlal Nehru', 'Allahabad,India', 'Pt. Jawaharlal Nehru was a freedom fighter, the first Prime Minister of India and a central figure in Indian politics before and after independence.\r\n', '2256_main.jpg', 'https://www.youtube.com/viaviwebtech/', 'https://www.instagram.com/viaviwebtech/', 'https://www.facebook.com/viaviweb', 'https://codecanyon.net/user/viaviwebtech/portfolio', 1),
(3, 'Mahatma Gandhi', 'Porbandar,India', 'Mohandas Karamchand Gandhi was an Indian activist who was the leader of the Indian independence movement against British rule. Employing nonviolent civil disobedience, Gandhi led India to independence and inspired movements for civil rights and freedom across the world.\r\n', '11647_mm.jpg', 'https://www.youtube.com/viaviwebtech/', 'https://www.instagram.com/viaviwebtech/', 'https://www.facebook.com/viaviweb', 'https://codecanyon.net/user/viaviwebtech/portfolio', 1),
(4, 'Ricardo Barreiro', 'Palermo, Buenos Aires, Argentina', 'Ricardo Barreiro was an Argentine comic book writer.\r\n', '75473_download.jpg', 'https://www.youtube.com/viaviwebtech/', 'https://www.instagram.com/viaviwebtech/', 'https://www.facebook.com/viaviweb', 'https://codecanyon.net/user/viaviwebtech/portfolio', 1),
(5, 'Vallabhbhai Patel', 'Nadiad,India', 'Vallabhbhai Patel, popularly known as Sardar Patel, was an Indian politician. He served as the first Deputy Prime Minister of India.\r\n', '57491_va.jpg', 'https://www.youtube.com/viaviwebtech/', 'https://www.instagram.com/viaviwebtech/', 'https://www.facebook.com/viaviweb', 'https://codecanyon.net/user/viaviwebtech/portfolio', 1),
(6, 'W Brian', 'Belfast, United Kingdom', 'William Brian Arthur is an economist credited with developing the modern approach to increasing returns. He has lived and worked in Northern California for many years. He is an authority on economics in relation to complexity theory, technology and financial markets.', '22441_bk_505_w_brian_arthur.jpg', 'https://www.youtube.com/viaviwebtech', 'https://www.instagram.com/viaviwebtech', 'https://www.facebook.com/viaviweb', 'https://codecanyon.net/user/viaviwebtech/portfolio', 1),
(10, 'Thomas Hardy', ' Stinsford, United Kingdom', 'A Victorian realist in the tradition of George Eliot, he was influenced both in his novels and in his poetry by Romanticism, including the poetry of William Wordsworth.', '57400_Untitled-1.jpg', 'https://www.youtube.com/viaviwebtech/', 'https://www.instagram.com/viaviwebtech/', 'https://www.facebook.com/viaviweb', 'https://codecanyon.net/user/viaviwebtech/portfolio', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `featured` int(1) NOT NULL DEFAULT 0,
  `book_title` varchar(500) NOT NULL,
  `book_description` text NOT NULL,
  `book_cover_img` varchar(255) NOT NULL,
  `book_bg_img` varchar(255) DEFAULT NULL,
  `book_file_type` varchar(255) NOT NULL,
  `book_file_url` varchar(255) NOT NULL,
  `total_rate` int(11) NOT NULL DEFAULT 0,
  `rate_avg` varchar(255) NOT NULL DEFAULT '0',
  `book_views` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `cat_id`, `sub_cat_id`, `aid`, `featured`, `book_title`, `book_description`, `book_cover_img`, `book_bg_img`, `book_file_type`, `book_file_url`, `total_rate`, `rate_avg`, `book_views`, `status`) VALUES
(8, 1, 0, 5, 0, 'Android Daily Motion Video App', '<p>Dailymotion Application is new application that offers users a great collection of Videos for your android device from dailymotion.</p>\r\n\r\n<p>You can make Application of Your favorite Videos, Tv Shows, Movies, Serials, Sports and many more from dailymotion.<br />\r\n<br />\r\nPurchase from here:&nbsp;<br />\r\n<a href=\"https://codecanyon.net/item/daily-motion/8239582?ref=viaviwebtech\">https://codecanyon.net/item/daily-motion/8239582?ref=viaviwebtech</a></p>\r\n\r\n<p>ANDROID SIDE:</p>\r\n\r\n<ol>\r\n	<li>Attractive UI with Material Design</li>\r\n	<li>Videos (Server video url and Daily motion)</li>\r\n	<li>Most view and latest video in home page</li>\r\n	<li>Advertisement slider</li>\r\n	<li>Category Wise Video Display</li>\r\n	<li>Favorite Video Display Separate</li>\r\n	<li>Video Change with Swiping finger</li>\r\n	<li>Navigation View</li>\r\n	<li>Google analytic tracking</li>\r\n	<li>One Signal Push Notification</li>\r\n	<li>Admob Ads Integration(Banner and interstitial ads)</li>\r\n	<li>Only Android Studio Code</li>\r\n	<li>Easy,powerful &amp; secure admin panel</li>\r\n</ol>\r\n\r\n<p>ADMIN SIDE:</p>\r\n\r\n<ul>\r\n	<li>Simple and Attractive Admin Panel.</li>\r\n	<li>Easily Manage Category and Videos.</li>\r\n	<li>About Us and Privacy Page Manage from Admin</li>\r\n	<li>Manage App Settings from Admin</li>\r\n</ul>\r\n\r\n<p>WHAT YOU GET:</p>\r\n\r\n<ul>\r\n	<li>Full Android Source Code.</li>\r\n	<li>Full Php Code of Server Side.</li>\r\n	<li>PSD Files</li>\r\n</ul>\r\n', '4196_11357_daily_motion_video_Banner.png', '18715_75919_single_movie_Banner.jpg', 'server_url', 'http://www.viaviweb.in/envato/cc/ebook_app_demo/uploads/1426_4994_99945_Beyond-Good-and-Evil-Galbraithcolor.epub', 0, '0', 0, 1),
(12, 6, 0, 6, 0, 'Android EBook App', '<p>E Book is an android application to read the books online &amp; offline. E Book Android App has user-friendly interface, easy to access. User can register, login, read the books,download books to read offline, share books via social media apps, rate books, comments books, search books and many more features within the app</p>\r\n\r\n<p>This is clean source code, buyer will get nice documentations for reskin the app and upload admin panel on server, it&rsquo;s preety easy.<br />\r\n<br />\r\nPurchase from here: <a href=\"https://codecanyon.net/item/android-ebook-app-with-material-design/21680614?ref=viaviwebtech\">Ebook Android app</a></p>\r\n\r\n<h3>Features</h3>\r\n\r\n<ul>\r\n	<li>Latest UI With Material Design</li>\r\n	<li>All Device Compatibility</li>\r\n	<li>Category Wise Book Listing</li>\r\n	<li>Category Wise Author Listing</li>\r\n	<li>Read Pdf Inside Application Without Download</li>\r\n	<li>Read Epub Inside Application After Download (Converted file doesn&rsquo;t supported)</li>\r\n	<li>Download Books</li>\r\n	<li>User can read downloaded books anytime without internet</li>\r\n	<li>Add to Favourite features for books</li>\r\n	<li>Comments And Ratings features for books</li>\r\n	<li>Login/Registration features</li>\r\n	<li>Mange profile feature</li>\r\n	<li>Share book via Social Media Apps installed in your device</li>\r\n	<li>Latest Navigation View</li>\r\n	<li>Rate App, More App And Share App links</li>\r\n	<li>Check Network Availability</li>\r\n	<li>Admob Integrated With Banner And Interstitial Ads</li>\r\n	<li>Easy Admin Panel for manage all the categories, authors, books, user</li>\r\n	<li>OneSignal Push Notification</li>\r\n	<li>Android Studio Code</li>\r\n</ul>\r\n\r\n<h3>Admin Side</h3>\r\n\r\n<ul>\r\n	<li>Simple and Attractive Admin Panel</li>\r\n	<li>Manage Books with Categories and Author</li>\r\n	<li>Manage App Users</li>\r\n	<li>App Settings Manage from Admin</li>\r\n	<li>About Us and Privacy Page Manage from Admin</li>\r\n	<li>Json Service</li>\r\n</ul>\r\n\r\n<h3>What You Get</h3>\r\n\r\n<ul>\r\n	<li>Full Android Source Code</li>\r\n	<li>Full Php Code of Server Side</li>\r\n	<li>PSD Design</li>\r\n</ul>\r\n\r\n<p><strong>Note :- Only Local And Server File Supported (epub and pdf file)</strong></p>\r\n', '25461_Android_Ebook_Banner.jpg', '97634_e-book_app_banner.jpg', 'server_url', 'http://www.viaviweb.in/envato/cc/ebook_app_demo/uploads/1426_4994_99945_Beyond-Good-and-Evil-Galbraithcolor.epub', 0, '0', 23, 1),
(16, 9, 0, 1, 1, 'Android Status App With Reward Point (Lucky Wheel, WA Status Saver, Video, GIF, Quotes & Image)', '<p>Android Status App furnish with plentiful Quotes, GIFs, images and videos. It is foremost application by viewing Quotes, GIFs, images and videos and you or your friend&rsquo;s reference code can obtain points by viewing and uploading Quotes, GIFs, images and videos. This app is easy to share GIFs, images, Videos and Quotes in social media. You can gaze at landscape and portrait videos and images.<br />\r\n<br />\r\nPurchase from here:<br />\r\n<a href=\"https://codecanyon.net/item/android-video-status-app-with-reward-points/22983826?ref=viaviwebtech\">https://codecanyon.net/item/android-video-status-app-with-reward-points/22983826?ref=viaviwebtech</a></p>\r\n\r\n<h3>Android Features</h3>\r\n\r\n<ul>\r\n	<li>Latest UI With Material Design</li>\r\n	<li>All Device Compatibility</li>\r\n	<li>Category Wise Status Listing</li>\r\n	<li>Status Share With Facebook, WhatsApp, Instagram, Twitter And Other Application</li>\r\n	<li>Download Status List</li>\r\n	<li>Upload video, image, gif, quotes status</li>\r\n	<li>User Uploaded Status List</li>\r\n	<li>Add To Favorite Features For Status</li>\r\n	<li>Status View And Like Features</li>\r\n	<li>Landscape, Portrait And Related Status List</li>\r\n	<li>Reward Point Features. User Status View And Upload Status Earn Reward Point</li>\r\n	<li>Register To The Application And Get Reward Point</li>\r\n	<li>Share Your Reference Code To Others And Get Reward Point For Every User Registered With Your Reference Code.</li>\r\n	<li>User Current Reward Point List</li>\r\n	<li>User Withdrawal Reward Point History And List</li>\r\n	<li>User Reward Point To Claim In Admin Panel</li>\r\n	<li>User Gets Notification When The Transaction Is Approved By The Admin</li>\r\n	<li>Login/Registration Features, Gmail and Facebook login</li>\r\n	<li>Manage profile feature</li>\r\n	<li>Comment and report for individual status</li>\r\n	<li>User Follow And Following</li>\r\n	<li>Email verification then register/SMTP email added in PHP web service</li>\r\n	<li>Faq and Contact us form</li>\r\n	<li>Latest Navigation View</li>\r\n	<li>Rate App, More App And Share App links</li>\r\n	<li>Check Network Availability</li>\r\n	<li>Admob Integrated With Banner, Interstitial And Rewarded Video Ads</li>\r\n	<li>Easy Admin Panel For Manage All The Video And User</li>\r\n	<li>OneSignal Push Notification</li>\r\n	<li>Watermark Feature (Only Download Video)</li>\r\n	<li>Android Studio Code With Latest Version 4.0</li>\r\n</ul>\r\n\r\n<h3>Admin Side</h3>\r\n\r\n<ul>\r\n	<li>Bootstrap 100% Responsive Design</li>\r\n	<li>Easy Installation</li>\r\n	<li>User-Friendly Dashboard (Graph Analytics, Record Statics)</li>\r\n	<li>Feature-Rich Admin Panel</li>\r\n	<li>Manage Categories</li>\r\n	<li>Manage Languages</li>\r\n	<li>Manage Home Slider</li>\r\n	<li>Manage Video, Image, GIF and Quotes Statuses</li>\r\n	<li>Manage Users and deleted users list</li>\r\n	<li>Manage Deleted Users List</li>\r\n	<li>Manage Verification request</li>\r\n	<li>Manage Transaction</li>\r\n	<li>Manage Lucky Wheel</li>\r\n	<li>Manage Notification and Notification Settings</li>\r\n	<li>Manage Settings (Reward Points, SMTP Settings, General Settings)</li>\r\n	<li>Added payment mode in admin panel settings. This is used when user fill reward point claim form and select payment mode</li>\r\n	<li>Handle Enable/Disable OTP Verification from App</li>\r\n	<li>Handle Upload Option Of Statuses (Show/Hide) from App</li>\r\n</ul>\r\n\r\n<h3>What You Get</h3>\r\n\r\n<ul>\r\n	<li>Full Android Source Code</li>\r\n	<li>Full Php Code of Server Side</li>\r\n	<li>PSD Design</li>\r\n</ul>\r\n\r\n<h3>Note</h3>\r\n\r\n<p><strong>When you share video status to any social media app, the length of the video will be depended on the app your sharing and Only Local/Server Video support(.mp4 format). YouTube Video not support. Payment Gateway Not Integrated</strong></p>\r\n', '20646_status_app_Banner.jpg', '42345_status_app_Banner.jpg', 'server_url', 'http://viaviweb.in/envato/cc/demo/books/93874_All-In-One-Videos.pdf', 0, '0', 0, 1),
(17, 10, 0, 1, 0, 'Single Movie Android App', '<p>Do you want to know everything about movies? Which movie is coming, who is the director, when is the release date or even if you want to listen to songs and watch video of the movie than here you go.<br />\r\nSingle Movie app is an complete package for the entire movie experience. You will find everything related to movies here in the app, there are separate sections given for each categories and interest such as star cast, movie trailer, video songs and many more. We have given the best possible user-interface and functions in the app with strong admin panel to manage the app. You may check other features which are given below and of course the demo apk is given for more clear idea. The code and documentation is very easy to understand and to work with for any individual developer.<br />\r\n<br />\r\nSo purchase the app, create your own Movie app and upload it to play store. For more information and support kindly contact us on given email address or on skype.<br />\r\n<br />\r\nPurchase form here:<br />\r\n<a href=\"https://codecanyon.net/item/single-movie-app/16861890?ref=viaviwebtech\">https://codecanyon.net/item/single-movie-app/16861890?ref=viaviwebtech</a></p>\r\n\r\n<h2>Android Side</h2>\r\n\r\n<ul>\r\n	<li>Wallpapers, Video and Songs</li>\r\n	<li>Total views and download of each wallpaper</li>\r\n	<li>Save or Share Wallpaper with your friends and on Social Networks</li>\r\n	<li>Set Wallpaper Option</li>\r\n	<li>Download songs</li>\r\n	<li>Server,Local,Youtube,Dailymotion and Vimeo Video Play(Only .mp4 Format Supported For Local and Server)</li>\r\n	<li>Movie Info</li>\r\n	<li>Latest UI with Material Design</li>\r\n	<li>Pinch Zoom and Double Tap Zoom on Wallpapers</li>\r\n	<li>Login/Register Profile</li>\r\n	<li>Home Banner With Social Media Link</li>\r\n	<li>All Device Combability</li>\r\n	<li>Check Network Availability</li>\r\n	<li>Admob with Banner and Interstitial ads Integrated</li>\r\n	<li>Easy Admin Panel with Latest Material Design</li>\r\n	<li>One Signal Push Notification</li>\r\n	<li>Android Studio Code 3.5.3</li>\r\n</ul>\r\n\r\n<h2>Admin Side</h2>\r\n\r\n<ol>\r\n	<li>Simple and Attractive Admin Panel</li>\r\n	<li>Manage Wallpapers, Video and Songs</li>\r\n	<li>Manage App Settings From Admin</li>\r\n	<li>Manage About Us and Privacy Page</li>\r\n	<li>Json Service</li>\r\n</ol>\r\n\r\n<h3>What You Get:</h3>\r\n\r\n<ol>\r\n	<li>Full Android Source Code</li>\r\n	<li>Full Php Code of Server Side</li>\r\n	<li>Android Package hierarchy (that tells which class is used for what)</li>\r\n	<li>Full Document with Screen Shot</li>\r\n</ol>\r\n', '45468_96362_single_movie_Banner.jpg', '91902_77581_Ecommerce_app_Banner.jpg', 'server_url', 'http://viaviweb.in/envato/cc/demo/books/31981_Viavi-Top-5-Android-Apps-Bundle.pdf', 0, '0', 0, 1),
(21, 3, 0, 2, 0, 'Android All In One Videos App', '<p>All In One Videos is new application that offers great collection of Video for your android device from Most Popular Video Sharing website. Are You thinking about to make video application that play video of your choice. You can make Application of Your favorite Video,Tv Shows,Movie,Serial,Sport and many more with different website.<br />\r\n<br />\r\nPurchase from here:<br />\r\n<a href=\"https://codecanyon.net/item/all-in-one-videos/9012163?ref=viaviwebtech\">https://codecanyon.net/item/all-in-one-videos/9012163?ref=viaviwebtech</a><br />\r\n<br />\r\n&nbsp;</p>\r\n\r\n<h2>Android Side:</h2>\r\n\r\n<ul>\r\n	<li>4 Type of Videos : Self Hosted,YouTube,Daily Motion,Vimeo</li>\r\n	<li>Attractive UI with Material Design.</li>\r\n	<li>Navigation View.</li>\r\n	<li>Video Display With Category Wise.</li>\r\n	<li>OneSignal Push Notification.</li>\r\n	<li>Google Analytic Tracking.</li>\r\n	<li>PSD Design.</li>\r\n	<li>Android Studio code.</li>\r\n	<li>Related videos.</li>\r\n	<li>Recently Added Video Display.</li>\r\n	<li>Add to Favorite Mode.</li>\r\n	<li>Favorite Video Display Separate.</li>\r\n	<li>You have upload video on your server also.(.mp4 and.3gp)</li>\r\n	<li>Search Video</li>\r\n	<li>Admob ads Integrated (Banner/Interstitial)</li>\r\n	<li>OneSignal Notification Added via Admin Panel</li>\r\n	<li>User Login and Registration</li>\r\n	<li>Video Comments</li>\r\n	<li>Check Network Availability.</li>\r\n</ul>\r\n\r\n<h2>Admin Side:</h2>\r\n\r\n<ul>\r\n	<li>Simple and Attractive Admin Panel.</li>\r\n	<li>Easily Manage Category.</li>\r\n	<li>Video Management</li>\r\n	<li>User Management</li>\r\n	<li>Comments and Notification Management</li>\r\n</ul>\r\n\r\n<h2>What You Get:</h2>\r\n\r\n<ul>\r\n	<li>Full Android Source Code.</li>\r\n	<li>Full Php Code of Server Side.</li>\r\n	<li>Full Document with Screen Shot.</li>\r\n</ul>\r\n', '76571_55251_All-In-One-Videos_Banner.jpg', '67126_55251_All-In-One-Videos_Banner.jpg', 'server_url', 'http://viaviweb.in/envato/cc/demo/books/51336_Viavi-Top-5-Android-Apps-Bundle.pdf', 0, '0', 2, 1),
(23, 2, 0, 1, 1, 'Android Live TV', '<p>Android Live Tv Application is app that show live tv on android device. Watch your favorite TV channels Live in your mobile phone with this Android application on your Android device. that support almost all format.The application is specially optimized to be extremely easy to configure and detailed documentation is provided.<br />\r\n<br />\r\nPurchase from here:<br />\r\n<a href=\"https://codecanyon.net/item/android-live-tv-with-material-design/7506537?ref=viaviwebtech\">https://codecanyon.net/item/android-live-tv-with-material-design/7506537?ref=viaviwebtech</a></p>\r\n\r\n<p>Android Side</p>\r\n\r\n<ul>\r\n	<li>Now New 2.0 Section for Movies &amp; Web Series</li>\r\n	<li>Movies added by there Language and Genre</li>\r\n	<li>Web Series added with Season and &nbsp;there Episode</li>\r\n	<li>Mini Player which is play within details screen</li>\r\n	<li>4 type of stream link&nbsp;</li>\r\n	<li>&nbsp;&nbsp; &nbsp;- Live Url (m3u8 type link which is play live tv )</li>\r\n	<li>&nbsp;&nbsp; &nbsp;- Youtube (play youtube video)</li>\r\n	<li>&nbsp;&nbsp; &nbsp;- Embedded url (Openload, VeryStream, Daily Motion, Vimo or other embeded website url)</li>\r\n	<li>&nbsp;&nbsp; &nbsp;- Server Url and Upload from system</li>\r\n	<li>New Design of Admin / App</li>\r\n	<li>Compatible with GDPR</li>\r\n	<li>Latest Version of Android Studio</li>\r\n	<li>Rating and Comment in Item</li>\r\n	<li>Chrome Cast (m3u8, mp4 &amp; http streaming support only)</li>\r\n	<li>OneSignal Notification inside Admin</li>\r\n	<li>Ads On/Off from Admin</li>\r\n	<li>Secure API Url</li>\r\n	<li>RTL Supported</li>\r\n	<li>All Device Combability(Responsive Design).</li>\r\n	<li>Easily Navigate With Navigation View.</li>\r\n	<li>Login, Register and Application Introduction</li>\r\n	<li>Play/Pause online TV/Video Stream.</li>\r\n	<li>Supports 720p/1080p HD mp4,mkv,m4v,rm,tp and many other video formats</li>\r\n	<li>YouTube Video Support.</li>\r\n	<li>Channel Added With Category Wise.</li>\r\n	<li>Favorite Mode.</li>\r\n	<li>Search Channel.</li>\r\n	<li>No Flash Player Required.</li>\r\n	<li>Easy Admin Panel with Latest Material Design</li>\r\n	<li>Admob ads Integrated(Banner/Interstital)</li>\r\n	<li>Only available Studio code</li>\r\n</ul>\r\n\r\n<p>Admin Side:</p>\r\n\r\n<ul>\r\n	<li>Simple and Attractive Admin Panel</li>\r\n	<li>Manage Category,Channel,Movies and Web Series</li>\r\n	<li>Easily Manage Users</li>\r\n	<li>Send Notification from Admin</li>\r\n	<li>Json Service</li>\r\n</ul>\r\n\r\n<p>What You Get:</p>\r\n\r\n<ul>\r\n	<li>Full Android Source Code.</li>\r\n	<li>Full Php Code of Server Side.</li>\r\n	<li>Android Package hierarchy (that tells which class is used for what).</li>\r\n	<li>Full Document with Screen Shot</li>\r\n</ul>\r\n', '26001_ebook_banner_image.jpg', '84695_Live-tv_Banner.jpg', 'server_url', 'http://viaviweb.in/envato/cc/demo/books/93874_All-In-One-Videos.pdf', 0, '0', 1, 1),
(25, 11, 17, 10, 0, 'Android Service Provider', '<p>This application is services information base application. Through the app, you can see services with provider detail information. Like beauty, home repairs and maintenance services, carpenter, electrician and plumber etc. The application is specially optimized to be extremely easy to configure and detailed documentation is provided.</p>\r\n\r\n<p>Purchase from here:&nbsp;&nbsp;<a href=\"https://codecanyon.net/item/android-service-providerprovidershome-servicesservices/27309466?s_rank=3\">Click Here</a></p>\r\n', '93116_service_banner.jpg', '1381_Services_Provider_Banner.jpg', 'server_url', 'http://viaviweb.in/envato/cc/demo/books/93874_All-In-One-Videos.pdf', 1, '5', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `show_on_home` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`, `show_on_home`, `status`) VALUES
(1, 'Life', '78970_sardar.jpg', 0, 1),
(2, 'Success', '904_32461_success_cat.jpg', 1, 1),
(3, 'Inspirational', '92186_Inspire_cat.jpg', 1, 1),
(6, 'Kids', '1963_66848_Kids_cat.png', 1, 1),
(9, 'History', '53193_cat_b.jpg', 1, 1),
(10, 'Technology', '33674_cat_c.jpg', 0, 1),
(11, 'Adventure', '43964_cat_a.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `comment_text` text CHARACTER SET utf8 NOT NULL,
  `comment_on` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_list`
--

CREATE TABLE `tbl_contact_list` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_subject` int(5) NOT NULL,
  `contact_msg` text NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_contact_list`
--

INSERT INTO `tbl_contact_list` (`id`, `contact_name`, `contact_email`, `contact_subject`, `contact_msg`, `created_at`) VALUES
(1, 'user', 'user.viaviweb@gmail.com', 2, 'Copyright book', '1610349260'),
(2, 'Ravina', 'ravina.viavi@gmail.com', 1, 'Nice!!', '1628067300'),
(3, 'Ravina', 'ravina.viavi@gmail.com', 3, 'Nice!!', '1628067332'),
(4, 'Ravina', 'ravina.viavi@gmail.com', 2, 'Nice!!', '1628067347'),
(5, 'Ravina', 'ravina.viavi@gmail.com', 1, 'Nice!!', '1628067535'),
(6, 'Kishan Viramgama', 'viramgama.kishan@gmail.com', 3, 'aaaa', '1628160509');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_sub`
--

CREATE TABLE `tbl_contact_sub` (
  `id` int(5) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contact_sub`
--

INSERT INTO `tbl_contact_sub` (`id`, `title`, `status`) VALUES
(1, 'Verification ', 1),
(2, 'Copyright', 1),
(3, 'Other', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favourite`
--

CREATE TABLE `tbl_favourite` (
  `fa_id` int(10) NOT NULL,
  `book_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `rate` int(11) NOT NULL,
  `dt_rate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` int(11) NOT NULL,
  `book_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `report` text NOT NULL,
  `report_on` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `onesignal_app_id` varchar(500) NOT NULL,
  `onesignal_rest_key` varchar(500) NOT NULL,
  `envato_buyer_name` varchar(200) NOT NULL,
  `envato_purchase_code` text NOT NULL,
  `envato_buyer_email` varchar(150) NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT 0,
  `package_name` varchar(150) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_email` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `app_author` varchar(255) NOT NULL,
  `app_contact` varchar(255) NOT NULL,
  `app_website` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `api_page_limit` int(11) NOT NULL,
  `api_latest_limit` int(3) NOT NULL,
  `api_cat_order_by` varchar(255) NOT NULL,
  `api_cat_post_order_by` varchar(255) NOT NULL,
  `api_author_order_by` varchar(255) NOT NULL,
  `api_author_post_order_by` varchar(255) NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `app_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `app_new_version` double NOT NULL DEFAULT 1,
  `app_update_desc` text NOT NULL,
  `app_redirect_url` text NOT NULL,
  `cancel_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `app_faq` text NOT NULL,
  `account_delete_intruction` text NOT NULL,
  `api_sub_cat_order_by` text NOT NULL,
  `api_sub_cat_post_order_by` text NOT NULL,
  `native_ad` varchar(20) NOT NULL DEFAULT 'false',
  `native_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `native_ad_id` text NOT NULL,
  `native_facebook_id` text NOT NULL,
  `native_cat_position` int(10) NOT NULL DEFAULT 1,
  `native_position` int(10) NOT NULL DEFAULT 1,
  `native_position_grid` int(10) NOT NULL DEFAULT 1,
  `publisher_id` varchar(500) NOT NULL,
  `interstital_ad` varchar(500) NOT NULL,
  `interstital_ad_id` varchar(500) NOT NULL,
  `interstital_ad_click` varchar(500) NOT NULL,
  `banner_ad` varchar(500) NOT NULL,
  `banner_ad_type` varchar(30) NOT NULL,
  `banner_ad_id` varchar(500) NOT NULL,
  `interstital_ad_type` varchar(30) NOT NULL,
  `facebook_interstital_ad_id` varchar(255) NOT NULL,
  `facebook_banner_ad_id` varchar(255) NOT NULL,
  `cat_show_home_limit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `from_email`, `onesignal_app_id`, `onesignal_rest_key`, `envato_buyer_name`, `envato_purchase_code`, `envato_buyer_email`, `envato_purchased_status`, `package_name`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `api_page_limit`, `api_latest_limit`, `api_cat_order_by`, `api_cat_post_order_by`, `api_author_order_by`, `api_author_post_order_by`, `app_privacy_policy`, `app_update_status`, `app_new_version`, `app_update_desc`, `app_redirect_url`, `cancel_update_status`, `app_faq`, `account_delete_intruction`, `api_sub_cat_order_by`, `api_sub_cat_post_order_by`, `native_ad`, `native_ad_type`, `native_ad_id`, `native_facebook_id`, `native_cat_position`, `native_position`, `native_position_grid`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_type`, `banner_ad_id`, `interstital_ad_type`, `facebook_interstital_ad_id`, `facebook_banner_ad_id`, `cat_show_home_limit`) VALUES
(1, 'info@viaviweb.in', '', '', '', '', '-', 0, 'com.example.androidebook', 'Android E Book', 'app_icon.png', 'user.viaviweb@gmail.com', '1.0', 'viaviwebtech', '+91 922 7777 522', 'www.viaviweb.com', '<p>E Book app is an android application.E Book App has user-friendly interface with easy to manage. The Quotes Pro are stored in Server Side for easy editing and better performance. You can create apps Different types of Category and Author.The application is specially optimized to be extremely easy to configure and detailed documentation is provided.</p>\r\n', 10, 10, 'category_name', 'DESC', 'author_name', 'DESC', '<p><strong>We are committed to protecting your privacy</strong></p>\r\n\r\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\r\n\r\n<p><strong>Information Collected</strong></p>\r\n\r\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\r\n\r\n<p><strong>Information Use</strong></p>\r\n\r\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\r\n\r\n<p><strong>Disclosing Information</strong></p>\r\n\r\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\r\n\r\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\r\n\r\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\r\n\r\n<p><strong>Changes to this Policy</strong></p>\r\n\r\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\r\n\r\n<p><strong>Contacting Us</strong></p>\r\n\r\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\r\n', 'false', 1, 'kindly you can update new version app', 'https://play.google.com/store/apps/developer?id=Viaan+Parmar', 'false', '<p><strong>We are committed to protecting your privacy</strong></p>\r\n\r\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\r\n\r\n<p><strong>Information Collected</strong></p>\r\n\r\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\r\n\r\n<p><strong>Information Use</strong></p>\r\n\r\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\r\n\r\n<p><strong>Disclosing Information</strong></p>\r\n\r\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\r\n\r\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\r\n\r\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\r\n\r\n<p><strong>Changes to this Policy</strong></p>\r\n\r\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\r\n\r\n<p><strong>Contacting Us</strong></p>\r\n\r\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>', '<p><strong>Contact&nbsp;</strong></p>\r\n\r\n<p><strong>Email :-&nbsp;&nbsp;</strong><strong>info@viaviweb.com</strong></p>', 'sub_cat_name', 'DESC', 'false', 'facebook', 'ca-app-pub-3940256099942544/2247696110', 'ca-app-pub-8356404931736973/8732534868', 4, 4, 7, 'pub-9456493320432553', 'false', 'ca-app-pub-3940256099942544/1033173712', '2', 'true', 'admob', 'ca-app-pub-9456493320432553/9503088427', 'admob', 'Only Admin Can See', 'Only Admin Can See', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(10) NOT NULL,
  `book_id` int(10) NOT NULL DEFAULT 0,
  `slider_type` varchar(30) DEFAULT NULL,
  `slider_title` varchar(150) DEFAULT NULL,
  `external_url` text DEFAULT NULL,
  `external_image` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `book_id`, `slider_type`, `slider_title`, `external_url`, `external_image`, `status`) VALUES
(1, 0, 'external', 'Online Shopping CMS', 'https://codecanyon.net/item/online-shopping-cms-ecommerce-system-ecommerce-marketplace-buy-sell-paypal-stripe-cod/25683842?s_rank=1', '58165_slider.png', 1),
(2, 0, 'external', 'Online Shopping CMS', 'https://codecanyon.net/item/video-streaming-portal-tv-shows-movies-sports-videos-streaming/25581885?s_rank=2', '69583_slider.png', 1),
(3, 0, 'external', 'Online Radio', 'https://codecanyon.net/item/online-shopping-cms-ecommerce-system-ecommerce-marketplace-buy-sell-paypal-stripe-cod/25683842?s_rank=1', '10145_slider.png', 1),
(5, 16, 'Book', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_type` varchar(20) NOT NULL DEFAULT 'server',
  `smtp_host` varchar(150) NOT NULL,
  `smtp_email` varchar(150) NOT NULL,
  `smtp_password` text NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `port_no` varchar(10) NOT NULL,
  `smtp_ghost` varchar(150) NOT NULL,
  `smtp_gemail` varchar(150) NOT NULL,
  `smtp_gpassword` text NOT NULL,
  `smtp_gsecure` varchar(20) NOT NULL,
  `gport_no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_smtp_settings`
--

INSERT INTO `tbl_smtp_settings` (`id`, `smtp_type`, `smtp_host`, `smtp_email`, `smtp_password`, `smtp_secure`, `port_no`, `smtp_ghost`, `smtp_gemail`, `smtp_gpassword`, `smtp_gsecure`, `gport_no`) VALUES
(1, 'server', '', '', '', 'ssl', '465', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_category`
--

CREATE TABLE `tbl_sub_category` (
  `sid` int(11) NOT NULL,
  `cat_id` varchar(255) NOT NULL,
  `sub_cat_name` varchar(255) NOT NULL,
  `sub_cat_image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sub_category`
--

INSERT INTO `tbl_sub_category` (`sid`, `cat_id`, `sub_cat_name`, `sub_cat_image`, `status`) VALUES
(8, '11', 'Star Wars', '13639_img_7.jpg', 1),
(15, '11', 'Puzzled', '5140_img_4.jpg', 1),
(16, '11', 'Amezon ', '193_img_5.jpg', 1),
(17, '11', 'Tarzan', '71529_img_3.jpg', 1),
(19, '11', 'Herry Potter', '35466_img_6.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `user_profile` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `confirm_code` varchar(255) NOT NULL,
  `auth_id` text NOT NULL,
  `device_id` text NOT NULL,
  `is_duplicate` int(1) NOT NULL DEFAULT 0,
  `registration_on` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_type`, `user_profile`, `name`, `email`, `password`, `phone`, `confirm_code`, `auth_id`, `device_id`, `is_duplicate`, `registration_on`, `status`) VALUES
(1, 'Normal', '34801_09082021123613_user.jpg', 'User', 'user.viaviweb@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1234567890', '', '', '', 0, '1628239846', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_continue`
--

CREATE TABLE `tbl_user_continue` (
  `con_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_con_date` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_continue`
--

INSERT INTO `tbl_user_continue` (`con_id`, `user_id`, `book_id`, `user_con_date`) VALUES
(4, 1, 25, '1610347575'),
(6, 3, 12, '1627647502');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_author`
--
ALTER TABLE `tbl_author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  ADD PRIMARY KEY (`fa_id`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_continue`
--
ALTER TABLE `tbl_user_continue`
  ADD PRIMARY KEY (`con_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_author`
--
ALTER TABLE `tbl_author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  MODIFY `fa_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user_continue`
--
ALTER TABLE `tbl_user_continue`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
