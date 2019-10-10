INSERT INTO `Country` (`ID`, `Name`, `Code`) VALUES 
(1, 'Finland', 'FIN');

INSERT INTO `Currency` (`ID`, `Name`, `Code`, `Symbol`) VALUES 
(1, 'Euro', 'EUR', '€');

INSERT INTO `Company` (`ID`, `Name`, `Email`) VALUES
(1, 'AutoPark', 'testemail@testautopark.fi'),
(2, 'Q-Park', 'testemail@testautopark.fi');

INSERT INTO `Garage` (`Company`, `Name`, `Price`, `Currency`, `Country`, `Latitude`, `Longitude`) VALUES
(1, 'Tampere Rautatientori', 2.0, 1, 1, 60.168607847624095, 24.932371066131623),
(1, 'Punavuori Garage', 1.5, 1, 1, 60.162562, 24.939453),
(1, 'Unknown', 3.0, 1, 1, 60.16444996645511, 24.938178168200714),
(1, 'Fitnesstukku', 3.0, 1, 1, 60.165219358852795, 24.93537425994873),
(1, 'Kauppis', 3.0, 1, 1, 60.17167429490068, 24.921585662024363),
(2, 'Q-Park1', 2.0, 1, 1, 60.16867390148751, 24.930162952045407);
