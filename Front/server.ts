// back/server.ts

import express from 'express';
import bodyParser from 'body-parser';
import cors from 'cors';

const app = express();
const port = 3000;

// Middleware
app.use(bodyParser.json());
app.use(cors());

// Routes
app.get('/Transfert/OrangeMoney/AvecCode', (req, res) => {
  res.send('Endpoint Transfert/OrangeMoney/AvecCode');
});

app.get('/Transfert/OrangeMoney/SansCode', (req, res) => {
  res.send('Endpoint Transfert/OrangeMoney/SansCode');
});

app.get('/Transfert/Wave', (req, res) => {
  res.send('Endpoint Transfert/Wave');
});

app.get('/Transfert/Wari', (req, res) => {
  res.send('Endpoint Transfert/Wari');
});

app.get('/Transfert/CB/Permanent', (req, res) => {
  res.send('Endpoint Transfert/CB/Permanent');
});

app.get('/Transfert/CB/Immediat', (req, res) => {
  res.send('Endpoint Transfert/CB/Immediat');
});

// Démarrer le serveur
app.listen(port, () => {
  console.log(`Le serveur est en cours d'exécution sur http://localhost:${port}`);
});
