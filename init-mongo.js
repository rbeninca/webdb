db.createUser({
  user: 'meuusuario',
  pwd: 'minhasenha',
  roles: [
    {
      role: 'readWrite',
      db: 'mydatabase',
    },
  ],
});

// Seleciona a database.
db = db.getSiblingDB('database');

// Cria a collection 'minhaCollection'.
db.createCollection('pessoas');
