    CREATE TABLE IF NOT EXISTS `Hiscores` (
      `Name` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
      `Score` int(11) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
    --
    -- Indexes for dumped tables
    --
    
    --
    -- Indexes for table `Hiscores`
    --
    ALTER TABLE `Hiscores`
      ADD UNIQUE KEY `Name` (`Name`);
