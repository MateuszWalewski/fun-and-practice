#include "ProblemWithFileMyExcept.h"

using namespace std;

ProblemWithFileMyExcept::ProblemWithFileMyExcept(){}
ProblemWithFileMyExcept::ProblemWithFileMyExcept(const string & fileName):fileName(fileName){}
ProblemWithFileMyExcept::~ProblemWithFileMyExcept(){}
string ProblemWithFileMyExcept::description()
{
    return "There is a problem with file " + fileName +". Check if exists";
}
