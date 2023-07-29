"use strict";
// back/server.ts
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = __importDefault(require("express"));
const body_parser_1 = __importDefault(require("body-parser"));
const cors_1 = __importDefault(require("cors"));
const app = (0, express_1.default)();
const port = 3000;
// Middleware
app.use(body_parser_1.default.json());
app.use((0, cors_1.default)());
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
