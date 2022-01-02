SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_star_in_const` (`_id` INT, `_const` INT)  insert into star_in_const values (null,_id,_const,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `alter_commentary` (`_id` INT, `_content` TEXT)  update commentary set content = _content where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `alter_post` (`_id` INT, `_content` MEDIUMTEXT)  update post set content = _content where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `alter_star_description` (`_id` INT, `_description` TINYTEXT)  update star set description = _description where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `alter_star_img_name` (`_id` INT, `_img_name` TINYTEXT)  update star set img_name = _img_name where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `alter_star_name` (`_id` INT, `_name` VARCHAR(15))  update star set name = _name where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `alter_star_password` (`_id` INT, `_password` TINYTEXT)  update star set password = _password where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_space_const` (`_name` VARCHAR(20), `_img_name` TINYTEXT)  insert into constellation values (null,_name,-1,_img_name,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_star` (`_name` VARCHAR(15), `_password` TINYTEXT, `_img_name` TINYTEXT)  insert into star values(null,_name,_password,_img_name,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_star_const` (`_name` VARCHAR(20), `_owner` INT, `_img_name` TINYTEXT)  insert into constellation values (null,_name,_owner,_img_name,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_commentary` (`_id` INT)  delete from commentary where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_message` (`_id` INT)  delete from message where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_notification` (`_id` INT)  delete from notification where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_post` (`_id` INT)  delete from post where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `report_error` (`_owner` INT, `_content` TEXT)  insert into reported_error values(null,_owner,_content,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `see_message` (`_id` INT)  update message set seen = true where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `see_notification` (`_id` INT)  update notification set seen = true where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `send_commentary` (`_owner` INT, `_post` INT, `_content` TEXT)  insert into commentary values(null,_owner, _post, _content,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `send_message` (`_emitter` INT, `_receptor` INT, `_content` MEDIUMTEXT)  begin
insert into message values (null,_emitter,_emitter,_receptor,_content,null,null,null); 
insert into message values (null,_receptor,_emitter,_receptor,_content,null,null,null);   
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `send_notification` (`_id` INT, `_title` TINYTEXT, `_content` TEXT)  insert into notification values (null,_id,_title,_content,null,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `send_post` (`_owner` INT, `_const` INT, `_content` MEDIUMTEXT)  insert into post values(null,_owner, _const, _content,null,null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `star_clear_nots` (`_id` INT)  delete from notification where owner = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `unsee_message` (`_id` INT)  update message set seen = false where id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `unsee_notification` (`_id` INT)  update notification set seen = false where id = _id$$

CREATE DEFINER=`root`@`localhost` FUNCTION `const_id_exists` (`_id` INT) RETURNS TINYINT(1) begin
	declare _exists int;
    set _exists = 0;
    select count(*) into _exists from constellation where id = _id;
    if _exists > 0 then
    return true;
    else
    return false;
    end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `const_is_permanent` (`_id` INT) RETURNS TINYINT(1) begin
declare _exists int;
set _exists = 0;
select count(*) into _exists from constellation where id = _id and owner = -1;
if _exists > 0 then
return true;
else 
return false;
end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `const_name_exists` (`_name` VARCHAR(20)) RETURNS TINYINT(1) begin
declare _count int;
select count(*) into _count from constellation where name = _name;
if _count > 0 then
 return true;
else
return false;
end if; 
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_const_id` (`_name` VARCHAR(20)) RETURNS INT(11) return (select id from constellation where name = _name)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_star_id` (`_name` VARCHAR(15)) RETURNS INT(11) return (select id from star where name = _name)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_star_password` (`_id` INT) RETURNS INT(11) return (select password from star where id = _id)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `star_comments_count` (`_id` INT) RETURNS INT(11) return (select count(*) from commentary where owner = _id)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `star_from_const` (`_id` INT, `_const` INT) RETURNS TINYINT(1) begin
declare _exists int;
set _exists = 0;
select count(*) into _exists from star_in_const where star = _id and const = _const;
if _exists > 0 then
return true;
else
return false;
end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `star_name_exists` (`_name` VARCHAR(15)) RETURNS TINYINT(1) begin
declare _count int;
select count(*) into _count from star where name = _name;
if _count > 0 then
 return true;
else
return false;
end if; 
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `star_nots_count` (`_id` INT) RETURNS INT(11) return (select count(*) from notification where owner = _id)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `star_posts_count` (`_id` INT) RETURNS INT(11) return (select count(*) from post where owner = _id)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `star_unots_count` (`_id` INT) RETURNS INT(11) return (select count(*) from notification where owner = _id and seen = false)$$

DELIMITER ;

CREATE TABLE `commentary` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELIMITER $$
CREATE TRIGGER `on_create_comment` BEFORE INSERT ON `commentary` FOR EACH ROW set new.date = utc_date(), new.time = utc_time()
$$
DELIMITER ;

CREATE TABLE `constellation` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `img_name` tinytext NOT NULL,
  `description` tinytext DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `constellation` (`id`, `name`, `owner`, `img_name`, `description`, `date`) VALUES
(1, 'CHAMELEON', -1, 'chameleon.svg', 'Constelação permanente', '2021-11-06'),
(2, 'HORSE', -1, 'horse.svg', 'Constelação permanente', '2021-11-06'),
(3, 'BIRD', -1, 'bird.svg', 'Constelação permanente', '2021-11-06');
DELIMITER $$
CREATE TRIGGER `on_create_const` BEFORE INSERT ON `constellation` FOR EACH ROW set new.description = "Mais uma constelação no Space!", new.date = utc_date(),  new.owner = -1
$$
DELIMITER ;

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `emitter` int(11) NOT NULL,
  `receptor` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `seen` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
DELIMITER $$
CREATE TRIGGER `on_create_msg` BEFORE INSERT ON `message` FOR EACH ROW set new.date = utc_date(), new.time = utc_time(), new.seen = false
$$
DELIMITER ;

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `content` text NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `seen` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELIMITER $$
CREATE TRIGGER `on_create_not` BEFORE INSERT ON `notification` FOR EACH ROW set new.date = utc_date(), new.time = utc_time(), new.seen = false
$$
DELIMITER ;

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `const` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELIMITER $$
CREATE TRIGGER `on_create_post` BEFORE INSERT ON `post` FOR EACH ROW set new.date = utc_date(), new.time = utc_time()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `on_delete_post` BEFORE DELETE ON `post` FOR EACH ROW delete from commentary where commentary.post = old.id
$$
DELIMITER ;

CREATE TABLE `reported_error` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TRIGGER `on_create_rerror` BEFORE INSERT ON `reported_error` FOR EACH ROW set new.date = utc_date(), new.time = utc_time()
$$
DELIMITER ;

CREATE TABLE `star` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `password` tinytext NOT NULL,
  `img_name` tinytext NOT NULL,
  `description` tinytext DEFAULT NULL,
  `birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TRIGGER `on_create_star` BEFORE INSERT ON `star` FOR EACH ROW set  new.description = "Sou uma estrela ✌", new.birth = utc_date()
$$
DELIMITER ;

CREATE TABLE `star_in_const` (
  `id` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  `const` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TRIGGER `on_star_enter_const` BEFORE INSERT ON `star_in_const` FOR EACH ROW set new.date = utc_date(), new.time = utc_time()
$$
DELIMITER ;


ALTER TABLE `commentary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `post` (`post`);

ALTER TABLE `constellation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `receptor` (`receptor`),
  ADD KEY `emitter` (`emitter`);

ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `const` (`const`);

ALTER TABLE `reported_error`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

ALTER TABLE `star`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `star_in_const`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `star_2` (`star`,`const`),
  ADD KEY `const` (`const`),
  ADD KEY `star` (`star`,`const`);


ALTER TABLE `commentary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

ALTER TABLE `constellation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

ALTER TABLE `reported_error`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `star`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `star_in_const`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `commentary`
  ADD CONSTRAINT `commentary_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `star` (`id`),
  ADD CONSTRAINT `commentary_ibfk_2` FOREIGN KEY (`post`) REFERENCES `post` (`id`);

ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `star` (`id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receptor`) REFERENCES `star` (`id`),
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`emitter`) REFERENCES `star` (`id`);

ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `star` (`id`);

ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `star` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`const`) REFERENCES `constellation` (`id`);

ALTER TABLE `reported_error`
  ADD CONSTRAINT `reported_error_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `star` (`id`);

ALTER TABLE `star_in_const`
  ADD CONSTRAINT `star_in_const_ibfk_1` FOREIGN KEY (`star`) REFERENCES `star` (`id`),
  ADD CONSTRAINT `star_in_const_ibfk_2` FOREIGN KEY (`const`) REFERENCES `constellation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
