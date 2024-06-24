import pandas as pd
from sqlalchemy import create_engine

# Configuração da conexão com o banco de dados
db_connection_str = 'postgresql://laravel_user:secret@127.0.0.1:5432/laravel_db'
db_connection = create_engine(db_connection_str)

# Ler o CSV
file_path = '/home/keroly/pesquisa/database/seeders/banco.csv'
df = pd.read_csv(file_path)

# Exibir as primeiras linhas para verificação
print(df.head())

# Renomear as colunas no DataFrame
df.columns = [
    "fontes", "familia_final", "nome_principal", "nomes_alternativos", "siglas", 
    "tem_formulario_preenchido", "existe", "existe_no_brasil", "genero", 
    "possui_mantenedora", "fontes2", "fundadores_m", "fundadores_f", 
    "com_hierarquia_m", "com_hierarquia_f", "sem_hierarquia_m", "sem_hierarquia_f", 
    "santo_m", "santo_f", "nomes_dos_fundadores", "fontes3", "datas_aprovacao", 
    "fontes4", "anos_reformulacao", "fontes5", "situacao_canonica", "tipo_de_vida", 
    "data_fundacao", "fontes6", "pais_fundacao", "estado_fundacao", "cidade_fundacao", 
    "fontes7", "chegada_ao_brasil_ano", "fontes8", "chegada_ao_brasil_estado", 
    "chegada_ao_brasil_municipio", "fontes9", "num_membros_grupo_fundador_religiosos", 
    "num_membros_grupo_fundador_leigos", "num_membros_grupo_fundador_nao_especificado", 
    "fontes10", "periodo_funcionamento_casas_no_brasil", "fontes11", 
    "periodo_funcionamento_casas_fechadas", "fontes12", "estados_onde_esta_presente", 
    "num_estados_onde_esta_presente", "fontes13", "num_casas_no_mundo", "fontes14", 
    "paises_onde_esta_presente", "num_paises_onde_esta_presente", "fontes15", 
    "membros_no_brasil", "sacerdotes", "irmaos", "postulantes", "novicos", "fontes16", 
    "dados_alternativos", "membros_no_mundo_total", "fontes17", 
    "org_hierarquica_adm_nomeacao", "org_hierarquica_adm_eleicao", 
    "org_hierarquica_adm_ambos", "org_hierarquica", "publicacoes_uso_interno", 
    "fontes18", "publicacoes_livres", "fontes19", "total_publicacoes", 
    "obras_sobre_congregacao", "total", "num_fontes_manuscritas", "carisma", "fontes20", 
    "missao_fundacao", "fontes21", "missao_hoje", "fontes22", "motivos_vinda", "fontes23", 
    "trabalhos_assumidos", "fontes24", "notas", "sede_no_brasil_cidade", 
    "sede_no_brasil_estado", "sede_no_brasil_eh_capital", "taxa_reproducao", 
    "proporcao_membros_formacao", "Proporção de membros em formação em relação ao total de membros"
]
#Limpeza de dados (Se necessário, ajuste aqui)
# Por exemplo, unindo colunas de fontes que possuem vírgulas:
df['fontes'] = df[['fontes', 'fontes2', 'fontes3', 'fontes4', 'fontes5', 'fontes6', 'fontes7', 'fontes8', 'fontes9', 'fontes10', 'fontes11', 'fontes12', 'fontes13', 'fontes14', 'fontes15', 'fontes16', 'fontes17', 'fontes18', 'fontes19', 'fontes20', 'fontes21', 'fontes22', 'fontes23', 'fontes24']].apply(lambda x: ','.join(x.dropna().astype(str)), axis=1)

# Removendo colunas adicionais de fontes após combiná-las
df.drop(columns=['fontes2', 'fontes3', 'fontes4', 'fontes5', 'fontes6', 'fontes7', 'fontes8', 'fontes9', 'fontes10', 'fontes11', 'fontes12', 'fontes13', 'fontes14', 'fontes15', 'fontes16', 'fontes17', 'fontes18', 'fontes19', 'fontes20', 'fontes21', 'fontes22', 'fontes23', 'fontes24'], inplace=True)

# Inserir os dados na tabela do PostgreSQL
df.to_sql('congregacoes', db_connection, if_exists='replace', index=False)
