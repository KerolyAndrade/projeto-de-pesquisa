import pandas as pd
from sqlalchemy import create_engine, text
from datetime import datetime

# Função para lidar com valores ausentes
def handle_missing(value):
    return value if pd.notna(value) else None

# Função para converter ano para data
def convert_year_to_date(year):
    return datetime.strptime(year, '%Y').date() if pd.notna(year) else None

# Carregar o arquivo CSV para um DataFrame do pandas
file_path = '/home/keroly/pesquisa/database/seeders/banco.csv'

# Inicializar DataFrame vazio
df = pd.DataFrame()

# Tentar carregar o arquivo CSV
try:
    df = pd.read_csv(file_path, sep=';', encoding='utf-8', on_bad_lines='skip')
except pd.errors.ParserError as e:
    print(f"Erro ao processar arquivo CSV: {e}")
    exit(1)
except Exception as e:
    print(f"Erro inesperado ao ler arquivo CSV: {e}")
    exit(1)

# Conexão com o PostgreSQL
engine = create_engine('postgresql://laravel_user:secret@127.0.0.1:5432/laravel')

# Mapear IDs de países
conn = engine.connect()
pais_id_map = {row['nome']: row['id'] for row in conn.execute(text("SELECT id, nome FROM Paises")).fetchall()}

# Iterar sobre as linhas do DataFrame e inserir no banco de dados
for index, row in df.iterrows():
    try:
        # Construir o dicionário de dados dinamicamente
        data = {
            'nome_principal': handle_missing(row.get('NOME PRINCIPAL')),
            'nomes_alternativos': handle_missing(row.get('NOMES ALTERNATIVOS')),
            'siglas': handle_missing(row.get('SIGLAS')),
            'familia_final': handle_missing(row.get('Família final')),
            'genero': handle_missing(row.get('M/F?')),
            'fontes': handle_missing(row.get('Fontes')),
            'datas_aprovacao': handle_missing(row.get('Datas de Aprovação (Constituições, Regras, Dir. Diocesano, Dir. Pontifício, Decretum Laudis)')),
            'anos_reformulacao': handle_missing(row.get('Anos de reformulação das Constituições')),
            'situacao_canonica': handle_missing(row.get('Situação canônica*')),
            'data_fundacao': convert_year_to_date(row.get('Data de fundação')),
            'pais_fundacao_id': pais_id_map.get(handle_missing(row.get('País de Fundação'))),
            'cidade_fundacao': handle_missing(row.get('Cidade de Fundação')),
            'chegada_brasil_estado': handle_missing(row.get('Chegada ao Brasil - Estado')),
            'chegada_brasil_municipio': handle_missing(row.get('Chegada ao Brasil - Município')),
            'membros_brasil': handle_missing(row.get('Membros no Brasil\n (Preferência para informações do AC2015)')),
            'irmaos_as': handle_missing(row.get('Irmãos/ãs *')),
            'postulantes': handle_missing(row.get('Postulantes *')),
            'novicos': handle_missing(row.get('Noviços *')),
            'carisma': handle_missing(row.get('Carisma')),
            'motivos_vinda': handle_missing(row.get('Motivos da vinda'))
            # Adicione aqui outras colunas conforme necessário
        }

        # Inserir no banco de dados usando SQL Alchemy
        conn.execute(text("""
            INSERT INTO congregations (
                nome_principal, nomes_alternativos, siglas, familia_final, genero, fontes, 
                datas_aprovacao, anos_reformulacao, situacao_canonica, data_fundacao, 
                pais_fundacao_id, cidade_fundacao, chegada_brasil_estado, chegada_brasil_municipio, 
                membros_brasil, irmaos_as, postulantes, novicos, carisma, motivos_vinda
                -- Adicione outras colunas aqui conforme necessário
            ) VALUES (
                :nome_principal, :nomes_alternativos, :siglas, :familia_final, :genero, :fontes, 
                :datas_aprovacao, :anos_reformulacao, :situacao_canonica, :data_fundacao, 
                :pais_fundacao_id, :cidade_fundacao, :chegada_brasil_estado, :chegada_brasil_municipio, 
                :membros_brasil, :irmaos_as, :postulantes, :novicos, :carisma, :motivos_vinda
                -- Adicione outros placeholders aqui conforme necessário
            )
        """), data)
    except Exception as e:
        print(f"Erro ao processar linha {index + 1} do arquivo CSV: {e}")

conn.close()
