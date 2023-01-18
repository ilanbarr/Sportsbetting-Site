create table users(
    username varchar(20) not null,
    salthash varchar(255) not null,
    joined timestamp not null default current_timestamp(),
    credit mediumint not null default 500,
    Primary Key (username)
)engine = InnoDB default character set = utf8 collate = utf8_general_ci;



create table wagers(
    betId mediumint(8) NOT NULL AUTO_INCREMENT,
    date_placed timestamp NOT NULL DEFAULT current_timestamp(),
    description varchar(200) NOT NULL,
    risk mediumint(8) NOT NULL,
    win  mediumint(8) NOT NULL,
    username varchar(20) NOT NULL,
    status varchar(20) not null,
    primary key (betID),
    foreign key (username) references users (username)

)engine = InnoDB default character set = utf8 collate = utf8_general_ci;


insert into wagers(description, risk, win, username, statu) values(test1, 110,100, pending);

INSERT INTO `wagers` (`description`, `risk`, `win`, `username`, `status`) VALUES ( 'test4', '110', '100', '123', 'pending');


alter table 'users' add 


api key: a556b68607a218bac43c12a29f9bdfc3

https://api.the-odds-api.com/v4/sports/?apiKey=a556b68607a218bac43c12a29f9bdfc3