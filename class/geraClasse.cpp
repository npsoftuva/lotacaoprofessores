#include <bits/stdc++.h>

using namespace std;

void printIdent (FILE *f, int id) {
  for (int i = 0; i < id; i++)
    fprintf(f, "  ");
}

void string2char (string s, char* S) {
  int sz = s.size(), i;

  for (i = 0; i < sz; i++)
    S[i] = s[i];

  S[i] = '\0';
}

int main () {
  int n, op, m, i, id = 1;
  string nome,
         ext = ".class.php",
         s;
  char Nome[50], A[50];

  printf("Seja bem vindo ao Gerador de Classe\n\n");

  while (true) {
    printf("Digite o nome da classe: ");
    cin >> s;
    transform (s.begin(), s.end(), s.begin(), ::tolower);
    s[0] -= 32;
    nome = s;

    printf("\nDigite a quantidade de atributos: ");
    cin >> n;

    vector<string> atributos(n);

    printf("\nDigite os atributos.\n");
    for (int i = 0; i < n; i++) {
      printf("%d. ", i + 1);
      cin >> s;
      transform (s.begin(), s.end(), s.begin(), ::tolower);
      atributos[i] = s;
    }

    printf("\nVocê deseja adicionar mais algum atributo? (1 - Sim, 2 - Não): ");
    cin >> op;

    if (op == 1) {
      printf("\nDigite a quantidade de atributos que você deseja acrescentar: ");
      cin >> m;

      atributos.resize(n + m);

      printf("\nDigite os novos atributos.\n");
      for (i = n; i < n + m; i++) {
        printf("%d. ", i + 1);
        cin >> atributos[i];
      }
      n += m;
    }

    printf("\nVocê deseja finalizar a classe? (1 - Sim, 2 - Não): ");
    cin >> op;

    if (op == 1) {
      FILE *f;
      string2char(nome, Nome);

      int sz = nome.size();

      char NomeFile[sz + 10];

      strcpy(NomeFile, Nome);

      for (i = sz; i < sz + 11; i++)
        NomeFile[i] = ext[i - sz];

      f = fopen(NomeFile,"w");
      fprintf(f, "<?php\n\n");
      printIdent(f, id);
      fprintf(f, "class %s {\n", Nome);
      id++;

      ///Adicionando os atributos
      for (i = 0; i < atributos.size(); i++) {
        printIdent(f, id);
        string2char(atributos[i], A);
        fprintf(f, "private $%s;\n", A);
      }

      for (i = 0; i < atributos.size(); i++) {
        ///Adicionando os metodos GET
        fprintf(f, "\n");
        printIdent(f, id);
        string2char(atributos[i], A);
        A[0] = toupper(A[0]);
        fprintf(f, "public function get%s() {\n", A);
        id++;
        printIdent(f, id);
        A[0] = tolower(A[0]);
        fprintf(f, "return $this->%s;\n", A);
        id--;
        printIdent(f, id);
        fprintf(f, "}\n");

        ///Adicionando os metodos SET
        fprintf(f, "\n");
        printIdent(f, id);
        string2char(atributos[i], A);
        A[0] = toupper(A[0]);
        fprintf(f, "public function set%s", A, A);
        A[0] = tolower(A[0]);
        fprintf(f, " ($%s) {\n", A);
        id++;
        printIdent(f, id);
        fprintf(f, "$this->%s = $%s;\n", A, A);
        id--;
        printIdent(f, id);
        fprintf(f, "}\n");
      }

      id--;
      printIdent(f, id);
      fprintf(f, "}\n?>");

      fclose(f);
    }
  }

  return 0;
}
