


ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64986383B10` FOREIGN KEY (`avatar_id`) REFERENCES `avatar` (`id`) ON DELETE CASCADE;
