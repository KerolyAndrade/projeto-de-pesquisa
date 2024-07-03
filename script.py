import pandas as pd
from sqlalchemy import create_engine

# Configuração da conexão com o banco de dados
db_connection_str = 'postgresql://laravel_user:secret@127.0.0.1:5432/laravel_db'
db_connection = create_engine(db_connection_str)

# Caminho correto para o arquivo CSV
file_path = '/home/keroly/pesquisa/database/seeders/banco.csv'
df = pd.read_csv(file_path)

# Remover a coluna Unnamed se existir
if 'Unnamed: 0' in df.columns:
    df = df.drop(columns=['Unnamed: 0'])

# Verifique os nomes das colunas no DataFrame
print(df.head())

# Verificar se 'País de Fundação' está presente
if 'País de Fundação' in df.columns:
    # Substitua valores estranhos por 'N/A'
    df['País de Fundação'] = df['País de Fundação'].replace(['1', 'F', 'N/E'], 'N/A')
else:
    print("A coluna 'País de Fundação' não foi encontrada no DataFrame.")

# Inserir os dados na tabela do PostgreSQL
df.to_sql('congregacoes', db_connection, if_exists='replace', index=False)
