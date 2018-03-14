CREATE TABLE `tbl_tasks` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`description` varchar(255), 
`due` date NOT NULL, 
`prio` int(11) NOT NULL DEFAULT '3'
);