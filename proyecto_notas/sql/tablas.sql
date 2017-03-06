create database dbnotas default character set utf8 collate utf8_unicode_ci;

create user admin@localhost identified by 'admin';

grant all on dbnotas.* to admin@localhost;

flush privileges;

use dbnotas;

create table usuario (
    id int auto_increment not null primary key,
    email varchar(150) unique not null,
    password varchar(256) not null,
    alias varchar(40) unique not null,
    falta datetime not null,
    tipo enum('administrador', 'usuario') not null default 'usuario',
    estado tinyint default '0'
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;


create table nota(
    id int auto_increment not null primary key,
    titulo varchar(30) not null,
    id_propietario int(11) not null,
    fecha datetime not null,
    privacidad enum ('privado', 'publico') not null default 'privado',
    color enum('amarillo', 'azul', 'verde', 'rosa') not null default 'amarillo',
    tipografia enum('Calibri', 'Cambria', 'Raleway', 'Satellite', 'Notera') not null default 'Calibri',
    tamano enum('12', '14', '16', '18', '24') not null default '14',
    constraint fk_idusuario foreign key(id_propietario) references usuario (id) on delete cascade on update cascade
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;


create table usuario_autorizado (
    idnota int not null primary key,
    id_usuario_autorizado int,
    constraint fk_nota_autorizado foreign key (idnota) references nota (id) on delete cascade on update cascade,
    constraint fk_usuario_autorizado foreign key (id_usuario_autorizado) references usuario (id) on delete cascade on update cascade
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;

create table notalista (
    idnotalista int not null auto_increment primary key,
    idnota int not null,
    lista boolean not null,
    texto varchar(500),
    constraint fk_notalista foreign key (idnota) references nota (id) on delete cascade on update cascade
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;

create table notaimagen(
    idnotaimagen int not null auto_increment primary key,
    idnota int not null, 
    path varchar(256),
    tipo varchar(15),
    constraint fk_notaimagen foreign key (idnota) references nota (id) on delete cascade on update cascade
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;