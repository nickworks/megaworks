-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 02, 2018 at 08:39 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mega`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` int(64) NOT NULL,
  `copy` text NOT NULL,
  `date_publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments_announcements`
--

DROP TABLE IF EXISTS `comments_announcements`;
CREATE TABLE `comments_announcements` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments_events`
--

DROP TABLE IF EXISTS `comments_events`;
CREATE TABLE `comments_events` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments_projects`
--

DROP TABLE IF EXISTS `comments_projects`;
CREATE TABLE `comments_projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments_projects`
--

INSERT INTO `comments_projects` (`id`, `user_id`, `project_id`, `date_posted`, `comment`) VALUES
(1, 1, 1, '2018-02-23 13:10:24', 'This project sucks. Get good.'),
(2, 1, 1, '2018-02-23 13:43:38', 'This is awesome!!!!');

-- --------------------------------------------------------

--
-- Table structure for table `comments_projects_tags`
--

DROP TABLE IF EXISTS `comments_projects_tags`;
CREATE TABLE `comments_projects_tags` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments_projects_tags`
--

INSERT INTO `comments_projects_tags` (`id`, `comment_id`, `tag_id`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(128) NOT NULL,
  `location_link` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `copy` text NOT NULL,
  `link` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `title`, `copy`, `link`) VALUES
(1, 'MIT', 'Copyright [YEAR] [NAME]\r\n\r\nPermission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the \"Software\"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:\r\n\r\nThe above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.\r\n\r\nTHE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.', 'https://opensource.org/licenses/MIT'),
(2, 'Apache', 'Copyright [YEAR] [NAME]\n\nLicensed under the Apache License, Version 2.0 (the \"License\");\nyou may not use this file except in compliance with the License.\nYou may obtain a copy of the License at\n\n  http://www.apache.org/licenses/LICENSE-2.0\n\nUnless required by applicable law or agreed to in writing, software\ndistributed under the License is distributed on an \"AS IS\" BASIS,\nWITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.\nSee the License for the specific language governing permissions and\nlimitations under the License.', '');

-- --------------------------------------------------------

--
-- Table structure for table `profile_contacts`
--

DROP TABLE IF EXISTS `profile_contacts`;
CREATE TABLE `profile_contacts` (
  `id` int(11) NOT NULL COMMENT 'I.D. for this array.',
  `user_id` int(11) NOT NULL COMMENT 'The id of the user who this information belongs to.',
  `text` text NOT NULL COMMENT 'The hyperlink text to show on the page.',
  `url` varchar(256) NOT NULL COMMENT 'The URL the link leads to.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile_links`
--

DROP TABLE IF EXISTS `profile_links`;
CREATE TABLE `profile_links` (
  `id` int(11) NOT NULL COMMENT 'I.D. for this array.',
  `user_id` int(11) NOT NULL COMMENT 'I.D. of the user this row belongs to.',
  `text` text NOT NULL COMMENT 'The hyperlink text to show on the page.',
  `url` varchar(256) NOT NULL COMMENT 'The URL the link leads to.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `user_id`, `license_id`) VALUES
(1, 'Tree of Life', 'In a giant tree, Nola embarks on an epic journey.\r\n\r\nIn Fall 2017, the DAGD 355 class created a prototype adventure-platformer in Unity.', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_attribution`
--

DROP TABLE IF EXISTS `project_attribution`;
CREATE TABLE `project_attribution` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `work` varchar(64) NOT NULL,
  `creator` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `work_link` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_attribution`
--

INSERT INTO `project_attribution` (`id`, `project_id`, `work`, `creator`, `user_id`, `license_id`, `work_link`) VALUES
(1, 1, 'Texture16.png', 'my uncle', 0, 1, 'http://google.com');

-- --------------------------------------------------------

--
-- Table structure for table `project_imgs`
--

DROP TABLE IF EXISTS `project_imgs`;
CREATE TABLE `project_imgs` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `url` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_imgs`
--

INSERT INTO `project_imgs` (`id`, `project_id`, `url`, `description`, `ordering`) VALUES
(1, 1, 'imgs/gallery/bloodborne.jpg', 'pictochat', 1),
(2, 1, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(17, 2, 'imgs/gallery/codmw2.jpg', 'pictochat', 1),
(18, 2, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(19, 3, 'imgs/gallery/darksouls.jpg', 'pictochat', 1),
(20, 3, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(21, 4, 'imgs/gallery/deliverance.jpg', 'pictochat', 1),
(22, 4, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(23, 5, 'imgs/gallery/destiny.jpg', 'pictochat', 1),
(24, 5, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(25, 6, 'imgs/gallery/few.jpg', 'pictochat', 1),
(26, 6, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(27, 7, 'imgs/gallery/galaxy.jpg', 'pictochat', 1),
(28, 7, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(29, 8, 'imgs/gallery/gdq.png', 'pictochat', 1),
(30, 8, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(31, 9, 'imgs/gallery/honor.jpg', 'pictochat', 1),
(32, 9, 'imgs/gallery/scalebound.jpg', 'pictochat', 2),
(33, 10, 'imgs/gallery/journey.jpg', 'pictochat', 1),
(34, 10, 'imgs/gallery/scalebound.jpg', 'pictochat', 2);

-- --------------------------------------------------------

--
-- Table structure for table `project_tags`
--

DROP TABLE IF EXISTS `project_tags`;
CREATE TABLE `project_tags` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_tags`
--

INSERT INTO `project_tags` (`id`, `project_id`, `tag_id`) VALUES
(1, 1, 2),
(2, 1, 4),
(3, 1, 8),
(4, 1, 9),
(5, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tags_comments`
--

DROP TABLE IF EXISTS `tags_comments`;
CREATE TABLE `tags_comments` (
  `id` int(11) NOT NULL,
  `text` varchar(32) NOT NULL,
  `warn` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags_comments`
--

INSERT INTO `tags_comments` (`id`, `text`, `warn`) VALUES
(1, 'Awesome', 0),
(2, 'Nice work', 0),
(3, 'Questionable Content', 1),
(4, 'Possible Infringement', 1),
(5, 'Critique', 0),
(6, 'Idea', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags_projects`
--

DROP TABLE IF EXISTS `tags_projects`;
CREATE TABLE `tags_projects` (
  `id` int(11) NOT NULL,
  `text` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags_projects`
--

INSERT INTO `tags_projects` (`id`, `text`) VALUES
(1, 'Game'),
(2, 'Art'),
(3, 'Animation'),
(4, 'Simulation'),
(5, 'Coding'),
(6, 'Project finished'),
(7, 'Looking for help'),
(8, 'Capstone'),
(9, 'Seeking critique'),
(10, 'UX'),
(11, 'Asset'),
(12, 'Group project');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `alias` varchar(32) NOT NULL,
  `title` varchar(64) NOT NULL,
  `first` varchar(32) NOT NULL,
  `last` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `salt` int(11) NOT NULL,
  `date_signup` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether or not the user has been approved.',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether or not the user has admin rights.',
  `is_mod` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether or not the user has moderation rights.',
  `bio` text NOT NULL COMMENT 'Stores the user''s bio to be displayed on their profile page.',
  `resume` varchar(256) NOT NULL COMMENT 'Stores the URL to the user''s resume.',
  `avatar` varchar(256) NOT NULL COMMENT 'Stores the URL to the profile picture.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `alias`, `title`, `first`, `last`, `email`, `hash`, `salt`, `date_signup`, `is_approved`, `is_admin`, `is_mod`, `bio`, `resume`, `avatar`) VALUES
(1, 'Nick', '', 'Nick', 'Pattison', 'patt41@ferris.edu', 'af3a0b99a3269b516a848b840fdf4c36', 1234, '2018-02-14 13:33:27', 1, 0, 0, '', '', ''),
(2, '', '', '', '', 'nick@ferris.edu', 'bc4586081f58bd9127939f420a298dc0', 52969, '2018-02-14 13:33:27', 0, 0, 0, '', '', ''),
(4, '', '', '', '', 'collin@ferris.edu', '5f9449ba01fb3bf921996d83dd46e9de', 17704, '2018-02-14 13:33:27', 0, 0, 0, '', '', ''),
(5, '', '', '', '', 'collin@ferris.edu', 'ef926983fef6f9c7f1207289ac8a0331', 21318, '2018-02-14 13:33:27', 0, 0, 0, '', '', ''),
(7, '', '', '', '', 'ethan@ferris.edu', '93a024e69eb89715828f6bc799ea966d', 19442, '2018-02-14 13:33:27', 0, 0, 0, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments_projects`
--
ALTER TABLE `comments_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments_projects_tags`
--
ALTER TABLE `comments_projects_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_contacts`
--
ALTER TABLE `profile_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_links`
--
ALTER TABLE `profile_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_attribution`
--
ALTER TABLE `project_attribution`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_imgs`
--
ALTER TABLE `project_imgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_tags`
--
ALTER TABLE `project_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags_comments`
--
ALTER TABLE `tags_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags_projects`
--
ALTER TABLE `tags_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments_projects`
--
ALTER TABLE `comments_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `comments_projects_tags`
--
ALTER TABLE `comments_projects_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `project_attribution`
--
ALTER TABLE `project_attribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `project_imgs`
--
ALTER TABLE `project_imgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `project_tags`
--
ALTER TABLE `project_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tags_comments`
--
ALTER TABLE `tags_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tags_projects`
--
ALTER TABLE `tags_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
