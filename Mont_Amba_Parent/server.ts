
import express from 'express';
import path from 'path';
import mysql from 'mysql2/promise';
import { fileURLToPath } from 'url';
import dotenv from 'dotenv';

dotenv.config();

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = 3000;

// MySQL Database setup
let db: mysql.Connection;

async function initDb() {
  try {
    db = await mysql.createConnection({
      host: process.env.DB_HOST || 'localhost',
      user: process.env.DB_USER || 'root',
      password: process.env.DB_PASSWORD || '',
      database: process.env.DB_NAME || 'gestion_paiement',
      port: Number(process.env.DB_PORT) || 3306
    });

    console.log('Connecté à MySQL avec succès');

    // Initialize tables
    await db.execute(`
      CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE,
        name VARCHAR(255)
      )
    `);

    await db.execute(`
      CREATE TABLE IF NOT EXISTS eleves (
        id INT PRIMARY KEY AUTO_INCREMENT,
        full_name VARCHAR(255),
        class_name VARCHAR(255),
        parent_id INT,
        total_fees DECIMAL(10, 2),
        paid_fees DECIMAL(10, 2),
        payment_status VARCHAR(50),
        FOREIGN KEY (parent_id) REFERENCES parents(id)
      )
    `);

    // Seed data if empty
    const [rows] = await db.execute('SELECT COUNT(*) as count FROM users');
    const count = (rows as any)[0].count;

    if (count === 0) {
      const [parentResult] = await db.execute('INSERT INTO users (email, name) VALUES (?, ?)', ['parent@amba.edu', 'M. Kouassi']);
      const parentId = (parentResult as any).insertId;

      await db.execute(
        'INSERT INTO eleves (prenom, nom, classe, id_user, statut) VALUES (?, ?, ?, ?, ?)',
        ['Jean-Luc', 'Kouassi', '3ème A', '00241', 'Paye']
      );
      await db.execute(
        'INSERT INTO eleves (prenom, nom, classe, id_user, statut) VALUES (?, ?, ?, ?, ?)',
        ['Marie-Claire', 'Kouassi', '6ème C', '00242', 'Tranche 1']
      );
      await db.execute(
        'INSERT INTO eleves (prenom, nom, classe, id_user, statut) VALUES (?, ?, ?, ?, ?)',
        ['Lucas', 'Kouassi', '7ème Préparatoire', '00243', 'Non paye']
      );
    }
  } catch (error) {
    console.error('Erreur de connexion MySQL:', error);
    process.exit(1);
  }
}

initDb();

app.use(express.json());
app.use(express.static('public'));

// API Routes
app.get('http://localhost/Mont_Amba_Parent/api/children.php', async (req, res) => {
  try {
    const id_user = '1'; 
    const [rows] = await db.execute('SELECT * FROM eleves WHERE id_user = ?', [id_user]);
    res.json(rows);
  } catch (error) {
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

app.post('http://localhost/Mont_Amba_Parent/api/pay.php', async (req, res) => {
  try {
    const { id_eleve, montant } = req.body;
    
    const [rows] = await db.execute('SELECT * FROM eleves WHERE id_eleve = ?', [id_eleve]);
    const child = (rows as any)[0];
    
    if (!child) return res.status(404).json({ error: 'Enfant non trouvé' });

    const newPaid = Number(child.frais_paye) + Number(montant);
    const newStatus = newPaid >= Number(child.frais_total) ? 'Paye' : 'Tranche 1';

    await db.execute('UPDATE eleves SET frais_paye = ?, statut = ? WHERE id_eleve = ?', [newPaid, newStatus, id_eleve]);

    res.json({ success: true, newStatus });
  } catch (error) {
    res.status(500).json({ error: 'Erreur lors du paiement' });
  }
});

// Serve HTML
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'http://localhost/Mont_Amba_Parent/public/index.html'));
});

app.listen(PORT, '0.0.0.0', () => {
  console.log(`Serveur scolaire en ligne sur http://localhost:${PORT}`);
});
