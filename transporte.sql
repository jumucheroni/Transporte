# Host: localhost  (Version 5.5.5-10.1.22-MariaDB)
# Date: 2018-11-06 21:47:14
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "ajudante"
#

CREATE TABLE `ajudante` (
  `cpf` varchar(11) NOT NULL DEFAULT '',
  `nome` varchar(100) NOT NULL DEFAULT '',
  `rg` varchar(9) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `salario` float NOT NULL DEFAULT '0',
  `logradouro` varchar(100) NOT NULL DEFAULT '',
  `cep` varchar(8) NOT NULL DEFAULT '',
  `numero` varchar(8) NOT NULL DEFAULT '',
  `bairro` varchar(30) NOT NULL DEFAULT '',
  `complemento` varchar(60) DEFAULT '',
  `cidade` varchar(30) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "condutor"
#

CREATE TABLE `condutor` (
  `cpf` varchar(11) NOT NULL DEFAULT '',
  `pgu` varchar(14) NOT NULL,
  `nome` varchar(100) NOT NULL DEFAULT '',
  `rg` varchar(9) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `salario` float NOT NULL DEFAULT '0',
  `logradouro` varchar(100) NOT NULL DEFAULT '',
  `cep` varchar(8) NOT NULL DEFAULT '',
  `numero` varchar(8) NOT NULL DEFAULT '',
  `bairro` varchar(30) NOT NULL DEFAULT '',
  `complemento` varchar(60) NOT NULL DEFAULT '',
  `cidade` varchar(30) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "escola"
#

CREATE TABLE `escola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL DEFAULT '',
  `tipo` varchar(1) NOT NULL DEFAULT '',
  `logradouro` varchar(100) NOT NULL DEFAULT '',
  `cep` varchar(8) NOT NULL DEFAULT '',
  `numero` varchar(8) NOT NULL DEFAULT '',
  `bairro` varchar(30) NOT NULL DEFAULT '',
  `complemento` varchar(60) NOT NULL DEFAULT '',
  `cidade` varchar(30) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '',
  `entrada_manha` varchar(255) DEFAULT '',
  `saida_manha` varchar(255) DEFAULT NULL,
  `entrada_tarde` varchar(255) DEFAULT NULL,
  `saida_tarde` varchar(255) DEFAULT NULL,
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Structure for table "responsavel"
#

CREATE TABLE `responsavel` (
  `cpf` varchar(11) NOT NULL DEFAULT '',
  `nome` varchar(100) NOT NULL DEFAULT '',
  `parentesco` varchar(60) NOT NULL DEFAULT '',
  `rg` varchar(9) DEFAULT NULL,
  `logradouro` varchar(100) NOT NULL DEFAULT '',
  `cep` varchar(8) NOT NULL DEFAULT '',
  `numero` varchar(8) NOT NULL DEFAULT '',
  `bairro` varchar(30) NOT NULL DEFAULT '',
  `complemento` varchar(60) NOT NULL DEFAULT '',
  `observacao` varchar(255) DEFAULT NULL,
  `cidade` varchar(30) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "crianca"
#

CREATE TABLE `crianca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf_responsavel` varchar(11) NOT NULL DEFAULT '',
  `id_escola` int(11) NOT NULL DEFAULT '0',
  `nome_professor` varchar(100) DEFAULT NULL,
  `data_nascimento` date NOT NULL DEFAULT '0000-00-00',
  `nome` varchar(100) NOT NULL DEFAULT '',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `id_escola` (`id_escola`),
  KEY `cpf_responsavel` (`cpf_responsavel`),
  CONSTRAINT `cpf_responsavel` FOREIGN KEY (`cpf_responsavel`) REFERENCES `responsavel` (`cpf`),
  CONSTRAINT `id_escola` FOREIGN KEY (`id_escola`) REFERENCES `escola` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

#
# Structure for table "contrato"
#

CREATE TABLE `contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensalidade` float NOT NULL DEFAULT '0',
  `data_inicio_contrato` date NOT NULL DEFAULT '0000-00-00',
  `data_fim_contrato` date NOT NULL DEFAULT '0000-00-00',
  `dia_vencimento_mensalidade` int(11) NOT NULL DEFAULT '0',
  `id_crianca` int(11) NOT NULL DEFAULT '0',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `id_crianca` (`id_crianca`),
  CONSTRAINT `id_crianca` FOREIGN KEY (`id_crianca`) REFERENCES `crianca` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "pagamentos"
#

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_prevista_pgto` date NOT NULL DEFAULT '0000-00-00',
  `data_realizada_pgto` date DEFAULT NULL,
  `valor_pago` float DEFAULT '0',
  `status` varchar(1) NOT NULL DEFAULT '',
  `id_contrato` int(11) NOT NULL DEFAULT '0',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `id_contrato` (`id_contrato`),
  CONSTRAINT `id_contrato` FOREIGN KEY (`id_contrato`) REFERENCES `contrato` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "telefone"
#

CREATE TABLE `telefone` (
  `telefone` varchar(11) NOT NULL DEFAULT '',
  `cpf_responsavel` varchar(11) NOT NULL,
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`telefone`,`cpf_responsavel`),
  KEY `cpf` (`cpf_responsavel`),
  CONSTRAINT `cpf` FOREIGN KEY (`cpf_responsavel`) REFERENCES `responsavel` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "trecho"
#

CREATE TABLE `trecho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(2) NOT NULL DEFAULT '',
  `logradouro_origem` varchar(100) NOT NULL DEFAULT '',
  `cep_origem` varchar(8) NOT NULL DEFAULT '',
  `numero_origem` varchar(8) NOT NULL DEFAULT '',
  `bairro_origem` varchar(30) NOT NULL DEFAULT '',
  `complemento_origem` varchar(60) NOT NULL DEFAULT '',
  `cidade_origem` varchar(30) NOT NULL DEFAULT '',
  `estado_origem` varchar(2) NOT NULL DEFAULT '',
  `logradouro_destino` varchar(100) NOT NULL DEFAULT '',
  `cep_destino` varchar(8) NOT NULL DEFAULT '',
  `numero_destino` varchar(8) NOT NULL DEFAULT '',
  `bairro_destino` varchar(30) NOT NULL DEFAULT '',
  `complemento_destino` varchar(60) NOT NULL DEFAULT '',
  `cidade_destino` varchar(30) NOT NULL DEFAULT '',
  `estado_destino` varchar(2) NOT NULL DEFAULT '',
  `id_escola` int(11) DEFAULT NULL,
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `escola` (`id_escola`),
  CONSTRAINT `escola` FOREIGN KEY (`id_escola`) REFERENCES `escola` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

#
# Structure for table "usuario"
#

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL DEFAULT '',
  `usuario` varchar(100) NOT NULL DEFAULT '',
  `senha` varchar(12) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Structure for table "veiculo"
#

CREATE TABLE `veiculo` (
  `placa` varchar(7) NOT NULL DEFAULT '',
  `lotacao` int(11) NOT NULL DEFAULT '0',
  `marca` varchar(30) DEFAULT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `ano` varchar(4) DEFAULT NULL,
  `cpf_ajudante` varchar(11) DEFAULT NULL,
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`placa`),
  KEY `cpf_ajudante` (`cpf_ajudante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "gastos"
#

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_gasto` date NOT NULL DEFAULT '0000-00-00',
  `valor_gasto` float NOT NULL DEFAULT '0',
  `tipo` varchar(1) NOT NULL DEFAULT '',
  `observacao` varchar(255) DEFAULT NULL,
  `placa_veiculo` varchar(7) NOT NULL DEFAULT '',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `placa_veiculo` (`placa_veiculo`),
  CONSTRAINT `placa_veiculo` FOREIGN KEY (`placa_veiculo`) REFERENCES `veiculo` (`placa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Structure for table "condutorveiculo"
#

CREATE TABLE `condutorveiculo` (
  `cpf_condutor` varchar(11) NOT NULL DEFAULT '',
  `placa_veiculo` varchar(7) NOT NULL,
  `periodo` varchar(2) NOT NULL DEFAULT '',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`cpf_condutor`,`placa_veiculo`,`periodo`),
  KEY `placa` (`placa_veiculo`),
  CONSTRAINT `cpf_condutor` FOREIGN KEY (`cpf_condutor`) REFERENCES `condutor` (`cpf`),
  CONSTRAINT `placa` FOREIGN KEY (`placa_veiculo`) REFERENCES `veiculo` (`placa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "criancatrecho"
#

CREATE TABLE `criancatrecho` (
  `id_crianca` int(11) NOT NULL AUTO_INCREMENT,
  `id_trecho` int(11) NOT NULL,
  `cpf_condutor` varchar(11) NOT NULL DEFAULT '',
  `placa_veiculo` varchar(7) NOT NULL DEFAULT '',
  `periodo_conducao` varchar(2) NOT NULL DEFAULT '',
  `id_contrato` int(11) DEFAULT '0',
  `deletado` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`id_crianca`,`id_trecho`),
  KEY `trecho` (`id_trecho`),
  KEY `condutor` (`cpf_condutor`),
  KEY `veiculo` (`placa_veiculo`),
  KEY `contrato` (`id_contrato`),
  KEY `periodo_conducao` (`periodo_conducao`),
  CONSTRAINT `condutor` FOREIGN KEY (`cpf_condutor`) REFERENCES `condutorveiculo` (`cpf_condutor`),
  CONSTRAINT `contrato` FOREIGN KEY (`id_contrato`) REFERENCES `contrato` (`id`),
  CONSTRAINT `crianca` FOREIGN KEY (`id_crianca`) REFERENCES `crianca` (`id`),
  CONSTRAINT `trecho` FOREIGN KEY (`id_trecho`) REFERENCES `trecho` (`id`),
  CONSTRAINT `veiculo` FOREIGN KEY (`placa_veiculo`) REFERENCES `condutorveiculo` (`placa_veiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
